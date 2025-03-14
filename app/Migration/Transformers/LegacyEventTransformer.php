<?php

namespace App\Migration\Transformers;

class LegacyEventTransformer
{
    /**
     * transform
     *
     * @param array $legacyEvent
     * @return array
     */
    public static function transform(array $legacyEvent): array
    {
        return [
            'id' => $legacyEvent['id_event'],
            'name' => $legacyEvent['event_name'],
            'type' => $legacyEvent['event_type'],
            'description' => $legacyEvent['event_desc'],
            'location' => $legacyEvent['event_location_name'],

            /** All fields available
             *  -----------------
            'id_event' => $legacyEvent['id_event'],
            'event_name' => $legacyEvent['event_name'],
            'id_church' => $legacyEvent['id_church'],
            'id_church_add' => $legacyEvent['id_church_add'],
            'id_event_contact' => $legacyEvent['id_event_contact'],
            'id_place' => $legacyEvent['id_place'],
            'id_event_cat' => $legacyEvent['id_event_cat'],
            'event_type' => $legacyEvent['event_type'],
            'event_desc' => $legacyEvent['event_desc'],
            'event_location_name' => $legacyEvent['event_location_name'],
            'event_location_detail' => $legacyEvent['event_location_detail'],
            'event_place_name' => $legacyEvent['event_place_name'],
            'event_address_street' => $legacyEvent['event_address_street'],
            'event_address_city' => $legacyEvent['event_address_city'],
            'event_address_state' => $legacyEvent['event_address_state'],
            'event_address_zip' => $legacyEvent['event_address_zip'],
            'event_address_county' => $legacyEvent['event_address_county'],
            'event_address_country' => $legacyEvent['event_address_country'],
            'event_geocode' => $legacyEvent['event_geocode'],
            'event_geo_lat' => $legacyEvent['event_geo_lat'],
            'event_geo_lng' => $legacyEvent['event_geo_lng'],
            'event_contact_name' => $legacyEvent['event_contact_name'],
            'event_contact_phone' => $legacyEvent['event_contact_phone'],
            'event_date_start' => $legacyEvent['event_date_start'],
            'event_date_end' => $legacyEvent['event_date_end'],
            'event_time_zone' => $legacyEvent['event_time_zone'],
            'event_slug' => $legacyEvent['event_slug'],
            'event_max_size' => $legacyEvent['event_max_size'],
            'event_position' => $legacyEvent['event_position'],
            'state' => $legacyEvent['state'],
            'date_add' => $legacyEvent['date_add'],
            'date_mod' => $legacyEvent['date_mod'],
            'date_removed' => $legacyEvent['date_removed'],
            'id_add' => $legacyEvent['id_add'],
            'id_mod' => $legacyEvent['id_mod'],
            'id_removed' => $legacyEvent['id_removed'],
            'has_childcare' => $legacyEvent['has_childcare'],
            'childcare_fee' => $legacyEvent['childcare_fee'],
            'show_count_adults' => $legacyEvent['show_count_adults'],
            'show_count_kids' => $legacyEvent['show_count_kids'],
            'show_count_meals_adults' => $legacyEvent['show_count_meals_adults'],
            'show_count_meals_kids' => $legacyEvent['show_count_meals_kids'],
            'show_ages_kids' => $legacyEvent['show_ages_kids'],
            'show_care_portal_option' => $legacyEvent['show_care_portal_option'],
            'id_org_internal' => $legacyEvent['id_org_internal'],
            'hide_change_event' => $legacyEvent['hide_change_event'],
            'hide_event_from_list' => $legacyEvent['hide_event_from_list'],
            'show_simple_form' => $legacyEvent['show_simple_form'],
            'show_tshirt_sizes' => $legacyEvent['show_tshirt_sizes'],
            'rsvp_show_address' => $legacyEvent['rsvp_show_address'],
            'orientation_event_complete_status' => $legacyEvent['orientation_event_complete_status'],
            'url_short' => $legacyEvent['url_short'],
            'url_church' => $legacyEvent['url_church'],
            'required_address' => $legacyEvent['required_address'],
            'event_key' => $legacyEvent['event_key'],
            'send_event_reminder' => $legacyEvent['send_event_reminder'],
            'send_event_followup' => $legacyEvent['send_event_followup'],
            'send_rsvp_confirmation' => $legacyEvent['send_rsvp_confirmation'],
            'meal_position' => $legacyEvent['meal_position'],
            'params' => $legacyEvent['params'],
            'is_virtual' => $legacyEvent['is_virtual'],
            'virtual_early_start' => $legacyEvent['virtual_early_start'],
            'virtual_event_type' => $legacyEvent['virtual_event_type'],
            'virtual_event_moderators' => $legacyEvent['virtual_event_moderators'],
            'virtual_event_password' => $legacyEvent['virtual_event_password'],
            'virtual_event_url_external' => $legacyEvent['virtual_event_url_external'],
            'virtual_event_lockout_time' => $legacyEvent['virtual_event_lockout_time'],
            'virtual_event_live_stream_url' => $legacyEvent['virtual_event_live_stream_url'],
            'email_body_response' => $legacyEvent['email_body_response'],
            'email_subject_response' => $legacyEvent['email_subject_response'],
            'repeat_freq' => $legacyEvent['repeat_freq'],
            'repeat_int' => $legacyEvent['repeat_int'],
            'repeat_date_end' => $legacyEvent['repeat_date_end'],
            'repeat_id_event' => $legacyEvent['repeat_id_event'],
            'event_all_day' => $legacyEvent['event_all_day'],
            'email_body_rsvp' => $legacyEvent['email_body_rsvp'],
            'email_subject_rsvp' => $legacyEvent['email_subject_rsvp'],
            'is_affiliate_hosted' => $legacyEvent['is_affiliate_hosted'],
            'is_confirmed' => $legacyEvent['is_confirmed'],
            'not_claimable' => $legacyEvent['not_claimable'],
            'email_body_notattend' => $legacyEvent['email_body_notattend'],
            'email_subject_notattend' => $legacyEvent['email_subject_notattend'],
            'tags' => $legacyEvent['tags'],
            'event_date_rsvp_end' => $legacyEvent['event_date_rsvp_end'],
            'access_level_min' => $legacyEvent['access_level_min'],
            **/
        ];
    }
}
