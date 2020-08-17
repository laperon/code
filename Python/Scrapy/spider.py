import scrapy
import sys
import os
import csv
import time
import pymongo
import requests
import json
import urllib.parse
import logging
from scrapy.crawler import CrawlerProcess
from scrapy import Selector
from selenium import webdriver
from datetime import datetime
from selenium.webdriver.common.by import By
from w3lib.html import remove_tags
from deprecated.sphinx import deprecated
from selenium.webdriver.remote.remote_connection import LOGGER
from selenium.common.exceptions import NoSuchElementException

class JobsSpider(scrapy.Spider):

    #Root project folder
    ROOT_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

    #Allowed domain
    allowed_domains = ['www.monster.fi']

    #Name of spider
    name = "jobs_spider"

    #Database name
    db_name = 'jobs'

    # List of services
    SERVICES = {
        'service1': {
            'protocol': 'https://',
            'domain': 'test.com',
            'search_url': '****',
        },

        'service2': {
            'protocol': 'https://',
            'domain': 'test1.com',
            'search_url': '****',
        },

        'service3': {
            'protocol': 'https://',
            'domain': 'test2.com',
            'search_url': '****',
        },

        'service4': {
            'protocol': 'https://',
            'domain': 'test3.com',
            'search_url': '****',
        }
    }

    #MogoDB connection
    mongo_url = 'mongodb://localhost:27017/'

    #Label should be use in terminal
    label_input = "Input company name >>>"

    def __init__(self):

        # Search by Keywords
        try:
            keyword = sys.argv[1]
        except:
            keyword = input('Enter Keyword: ')

        self.keyword = keyword

        #connect to mongoDB
        self.mongo_db_integration()

        #select chromedriver
        self.chromedriver = webdriver.Chrome(self.ROOT_DIR+'/chromedriver')

        #Set logging warning
        LOGGER.setLevel(logging.WARNING)
        logging.getLogger("urllib3").setLevel(logging.WARNING)

    def start_requests(self):
        #duunitori service
        yield scrapy.Request(self.SERVICES['service1']['search_url'].replace('%%str%%', urllib.parse.quote(self.keyword)),
            callback=self.parse_duunitori_jobs,
            dont_filter=True)

        #monster service
        yield scrapy.Request(self.SERVICES['service2']['search_url'].replace('%%str%%', urllib.parse.quote(self.keyword)),
            callback=self.parse_monster_jobs,
            dont_filter=True)

        #paikat service
        yield scrapy.Request(self.SERVICES['service3']['search_url'].replace('%%str%%', urllib.parse.quote(self.keyword)),
            callback=self.parse_paikat_jobs,
            dont_filter=True)

        #linkedin service
        yield scrapy.Request(self.SERVICES['service4']['search_url'].replace('%%str%%', urllib.parse.quote(self.keyword)),
            callback=self.parse_linkedin_jobs,
            dont_filter=True)

    def mongo_db_integration(self):
        """
        Initialisation Database settings
        """

        mongoclient = pymongo.MongoClient(self.mongo_url)
        collections = mongoclient['jobs'].list_collection_names()

        if 'services' not in collections:
            mongoclient[self.db_name].create_collection('services')

        self.db = mongoclient['jobs']


    def parse_duunitori_jobs(self, response):
        """
        Dunitory Service
        :param response:
        :return:
        """

        links = response.xpath('/html/body/div[9]/div/div[1]/div[1]/div/div/a/@href').extract()
        if len(links) is not 0:
            for link in links:
                url = self.SERVICES['duunitori']['protocol'] + self.SERVICES['duunitori']['domain']+link
                yield scrapy.Request(url, callback=self.parse_duunitori_jobs, dont_filter=True)
        else:
            job_title = response.xpath('/html/body/div[7]/div/div[1]/div[1]/div[1]/div[3]/h1/text()').get()
            job_location = response.xpath('/html/body/div[7]/div/div[2]/div[1]/div/div[1]/div[1]/div/div/a/span/text()').get()
            job_description = response.xpath('/html/body/div[7]/div/div[1]/div[1]/div[2]/div[1]/div').extract()

            if len(job_description) > 0:
                job_description = remove_tags(job_description[0])

            # Save data to Database
            self.save_data_to_db('duunitori', job_title, job_description, job_location)

    def parse_paikat_jobs(self, response):
        """
        Paikat Service
        :param response:
        :return:
        """

        url = response.request.url
        browser = self.chromedriver
        browser.get(url)

        try:
            first_item = browser.find_element(By.XPATH, '//*[@id="groupedList"]/accordion-group[1]/div/div[2]/div/div')
            if first_item.is_displayed():
                time.sleep(1)
                first_item.click()
                time.sleep(1)
                next_link = browser.find_element(By.XPATH,
                                                 '//html/body/tpt-root/div[2]/tpt-detail/div/div/div/div/div[3]/div')
                if next_link.is_displayed():
                    time.sleep(0.5)
                    job_title = browser.find_element(By.XPATH,
                                                     '/html/body/tpt-root/div[2]/tpt-detail/div/div/div/div/div[2]/div[1]/div[1]').get_attribute(
                        'innerHTML')
                    job_description = browser.find_element(By.XPATH,
                                                           '/html/body/tpt-root/div[2]/tpt-detail/div/div/div/div/div[2]/tpt-tabs-component/div[2]/tpt-tab-component[1]/div/p[1]').get_attribute(
                        'innerHTML')

                    # change tab
                    browser.find_element(By.XPATH,
                                         '/html/body/tpt-root/div[2]/tpt-detail/div/div/div/div/div[2]/tpt-tabs-component/div[1]/ul/li[2]/a').click()
                    time.sleep(0.5)

                    job_location = browser.find_element(By.XPATH,
                                                        '/html/body/tpt-root/div[2]/tpt-detail/div/div/div/div/div[2]/tpt-tabs-component/div[2]/tpt-tab-component[2]/div/div[3]/div/div[2]').get_attribute(
                        'innerHTML')

                    self.save_data_to_db('monster', job_title, job_description, job_location)

                    next_link.click()
        except NoSuchElementException:
            return None

        browser.close()

    def parse_monster_jobs(self, response):
        """
        Monster Service
        :param response:
        :return:
        """

        url = response.request.url
        browser = self.chromedriver
        browser.get(url)
        button_elements = browser.find_elements(By.XPATH, '//*[@id="SearchResults"]/section[contains(@class, "is-bold")]')
        time.sleep(2)
        browser.find_element(By.XPATH, '//*[@id="cookie-modal"]/div/div/div/a').click()
        for item in button_elements:
            item.click()
            time.sleep(1)

            job_title = item.find_element(By.XPATH, '//div/header/h2/a').get_attribute("innerHTML")
            job_location = item.find_element(By.XPATH, '//div/div[@class="location"]/a').get_attribute("innerHTML")
            try:
                job_description = remove_tags(browser.find_element(By.XPATH, '//*[@id="TrackingJobBody"]').get_attribute("innerHTML"))
            except:
                job_description = 'Empty'

            # Save data to Database
            self.save_data_to_db('monster', job_title, job_description, job_location)

        browser.close()


    def parse_linkedin_jobs(self, response):
        """
        Linkedin Service
        :param response:
        :return:
        """

        selectors = response.xpath('/html/body/main/div/section/ul/li')
        for selector in selectors:
            job_title = selector.xpath('a/span/text()').get()
            job_location = selector.xpath('div[1]/div/span[1]/text()').get()
            job_description = selector.xpath('div[1]/div/p/text()').get()

            #Save data to Database
            self.save_data_to_db('linkedin', job_title, job_description, job_location)

    @deprecated(version='1.0', reason="This function will be removed soon")
    def save_data_to_csv(self, name, data):
        """
        Save data to csv
        :param name:
        :param data:
        :return:
        """

        with open(self.ROOT_DIR+'/csv/'+name+'_data.csv', mode='a') as product_file:
            products = csv.writer(
                product_file, delimiter='|', quotechar='"', quoting=csv.QUOTE_MINIMAL)
            products.writerow(data)

    def save_data_to_db(self, service, title, description, location):
        """
        Save data to MongoDB
        :param service:
        :param title:
        :param description:
        :param location:
        :return:
        """

        self.db['services'].insert_many([{
            'service': service,
            'job_title': title,
            'description': description,
            'location': location,
            'keyword': self.keyword
        }])

        # try:
        #
        # except :
        #     self.dump('Database error')


    #@deprecated(version='1.0', reason="This function will be removed soon")
    def dump(self, key):
        """
        Dump variable
        :param key:
        :return:
        """

        print('================================== start ==========================================>')
        print(key)
        print('================================== end ============================================>')

process = CrawlerProcess()
process.crawl(JobsSpider)
process.start()
