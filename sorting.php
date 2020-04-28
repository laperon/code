$subservice_input = esc_sql($options['subservice']);
$quarantine = get_field('quarantine', 'options');
foreach ($rows as $row){

    $only_remote = get_field('does_only_remote_therapy', $row->therapist_id);
    $row->only_remote = $only_remote;

    $this->getTherapistLocation($row, $quarantine, $options);

    if(!empty($kelaStatus[$row->employe_id])) {
        $row->kela_status = $kelaStatus[$row->employe_id]['kela_status'];
    }

    $day = date_i18n('j.', strtotime($row->date));

    if (get_locale() === 'fi') {
        $numberMonth = date_i18n('n', strtotime($row->date));
        $month = $listOfFinishMonth[$numberMonth];
    } else {
        $month = date_i18n('F', strtotime($row->date));
    }

    $row->day_of_week = date_i18n('l', strtotime($row->date));

    $row->date_of_year = strtoupper($row->day_of_week). ' '.$day.' '.$month;

    $row->therapist_image = array(
        'search' => $this->getTherapistSearchImage($row->therapist_id),
        'main' => $this->getTherapistMainImage($row->therapist_id)
    );

    $groupResult[$row->date]['date_format'] = $row->date_of_year;
    $groupResult[$row->date]['time'][$row->time][$row->therapist_id]['subservices'][] = [
        'appointment_id'    => $row->appointment_id,
        'default_price'     => $row->default_price,
        'treatment_id'      => $row->treatment_id,
        'time'              => $row->time,
        'location_id'       => $row->location_id,
        'location_title'    => $row->location_title,
        'locations_address' => $row->locations_address,
        'city'              => $row->city,
        'city_id'           => $row->city_id,
        'corporate_id'      => $row->corporate_id,
        'price'             => $row->price,
        'subservice_id'     => $row->subservice_id,
        'subservice_title'  => $row->subservice_title,
        'sub_services_short_description' => $row->sub_services_short_description,
        'sub_services_icon' => $row->sub_services_icon
    ];

    $groupTherapist[$row->therapist_id] = $row;
    $groupSubservices[$row->subservice_id] = $row;
}
/**
 * Check if user has kela
 */
foreach($groupTherapist as $t_id => $item) {
    if(strpos($item->s_list, '4167') == true && $item->kela_status !='available') {
        $groupTherapist[$t_id]->kela_status = 'unavailable';
    }
}

/**
 * Sorting
 */
foreach($groupResult as $date => $row) {
    foreach($row['time'] as $time => $time_row) {
        foreach($time_row as $t_id => $therapist){

            $key_found = false;
            $sortSubArr = [];
            $inputSubArr = [];
            foreach($therapist['subservices'] as $key => $subservice) {
                /**
                 * Find selected IDs in subservices
                 */
                if(!empty($subservice_input) && in_array($subservice['subservice_id'] , $subservice_input)) {
                    $inputSubArr[] = $subservice;
                    // array_unshift($sortSubArr, $subservice);

                    $key_found = true;
                } else {
                    $sortSubArr[]=$subservice;
                    // asort($sortSubArr);

                }
            }
            array_multisort(array_column($sortSubArr, 'subservice_title'), SORT_ASC, $sortSubArr);

            if(!empty($subservice_input)){

                $groupResult[$date]['time'][$time][$t_id]['subservices'] = array_merge($inputSubArr, $sortSubArr);

                /**
                 * Remove row if key not found
                 */
                if($key_found == false) {
                    unset($groupResult[$date]['time'][$time][$t_id]);
                    if(empty($groupResult[$date]['time'][$time])){
                        unset($groupResult[$date]['time'][$time]);
                        if(empty($groupResult[$date]['time'])){
                            unset($groupResult[$date]);
                        }
                    }
                }
            } else {
                $groupResult[$date]['time'][$time][$t_id]['subservices'] = $sortSubArr;
            }
        }
    }
}

$rows = array(
    'therapists' => $groupTherapist,
    'subservices' => $groupSubservices,
    'results_count' => count($groupResult),
    'results' => $groupResult,
    'formFields' => array_values($this->getFormFields())
);

return $rows;
