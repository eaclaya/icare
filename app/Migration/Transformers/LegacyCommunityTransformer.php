<?php

namespace App\Migration\Transformers;

class LegacyCommunityTransformer
{
    /**
     * transform
     *
     * @param array $legacyCommunity
     * @return array
     */
    public static function transform(array $legacyCommunity): array
    {
        return [
            'id' => $legacyCommunity['id_community'],
            'name' => $legacyCommunity['community_name'],
            'desc' => $legacyCommunity['community_desc'],
            'type' => $legacyCommunity['community_type'],

            /** All fields available
             *  -----------------
            'id_community' => $legacyCommunity['id_community'],
            'community_name' => $legacyCommunity['community_name'],
            'community_desc' => $legacyCommunity['community_desc'],
            'community_notes_promise' => $legacyCommunity['community_notes_promise'],
            'community_notes_advocate' => $legacyCommunity['community_notes_advocate'],
            'community_type' => $legacyCommunity['community_type'],
            'state' => $legacyCommunity['state'],
            'state_reason' => $legacyCommunity['state_reason'],
            'date_add' => $legacyCommunity['date_add'],
            'date_mod' => $legacyCommunity['date_mod'],
            'date_start' => $legacyCommunity['date_start'],
            'date_end' => $legacyCommunity['date_end'],
            'date_removed' => $legacyCommunity['date_removed'],
            'date_sync' => $legacyCommunity['date_sync'],
            'id_add' => $legacyCommunity['id_add'],
            'id_mod' => $legacyCommunity['id_mod'],
            'id_church_add' => $legacyCommunity['id_church_add'],
            'population_served' => $legacyCommunity['population_served'],
            'agency' => $legacyCommunity['agency'],
            'case_worker_name' => $legacyCommunity['case_worker_name'],
            'case_worker_email' => $legacyCommunity['case_worker_email'],
            'case_worker_phone' => $legacyCommunity['case_worker_phone'],
            'community_address_street_1' => $legacyCommunity['community_address_street_1'],
            'community_address_street_2' => $legacyCommunity['community_address_street_2'],
            'community_address_city' => $legacyCommunity['community_address_city'],
            'community_address_state' => $legacyCommunity['community_address_state'],
            'community_address_zip' => $legacyCommunity['community_address_zip'],
            'community_address_country' => $legacyCommunity['community_address_country'],
            'community_county' => $legacyCommunity['community_county'],
            'community_geocode' => $legacyCommunity['community_geocode'],
            'community_geo_lat' => $legacyCommunity['community_geo_lat'],
            'community_geo_lng' => $legacyCommunity['community_geo_lng'],
            'community_food_allergies' => $legacyCommunity['community_food_allergies'],
            'community_food_preferences' => $legacyCommunity['community_food_preferences'],
            'community_meal_day_preference' => $legacyCommunity['community_meal_day_preference'],
            'community_meal_time_preference' => $legacyCommunity['community_meal_time_preference'],
            'community_time_zone' => $legacyCommunity['community_time_zone'],
            'community_home_type' => $legacyCommunity['community_home_type'],
            'community_meal_people_count' => $legacyCommunity['community_meal_people_count'],
            'meal_rotation' => $legacyCommunity['meal_rotation'],
            'meal_frequency' => $legacyCommunity['meal_frequency'],
            'status_foster' => $legacyCommunity['status_foster'],
            'status_adoption' => $legacyCommunity['status_adoption'],
            'previously_served_on_cc' => $legacyCommunity['previously_served_on_cc'],
            'previously_fostered' => $legacyCommunity['previously_fostered'],
            'recruited_by_church' => $legacyCommunity['recruited_by_church'],
            'url_avatar' => $legacyCommunity['url_avatar'],
            'id_salesforce' => $legacyCommunity['id_salesforce'],
            'id_import_batch' => $legacyCommunity['id_import_batch'],
            'id_promise' => $legacyCommunity['id_promise'],
            'iteration' => $legacyCommunity['iteration'],
            'id_batch' => $legacyCommunity['id_batch'],
            'id_org_internal' => $legacyCommunity['id_org_internal'],
            'params' => $legacyCommunity['params'],
            'placement_kinship' => $legacyCommunity['placement_kinship'],
            'placement_foster' => $legacyCommunity['placement_foster'],
            'placement_adoptive' => $legacyCommunity['placement_adoptive'],
            'placement_bio_reunify' => $legacyCommunity['placement_bio_reunify'],
            'id_event_set' => $legacyCommunity['id_event_set'],
            'last_meal_details' => $legacyCommunity['last_meal_details'],
            'last_meal_date' => $legacyCommunity['last_meal_date'],
            'id_place' => $legacyCommunity['id_place'],
            'id_end' => $legacyCommunity['id_end'],
            'hide_from_calendar' => $legacyCommunity['hide_from_calendar'],
            ***/


        ];
    }
}
