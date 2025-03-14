<?php

namespace App\Migration\Transformers;

class LegacyUserTransformer
{
    /**
     * transform
     *
     * @param array $legacyUser
     * @return array
     */
    public static function transform(array $legacyUser): array
    {
        return [
            'id' => $legacyUser['id_people'],
            'name_first' => $legacyUser['name_first'],
            'name_last' => $legacyUser['name_last'],
            'email' => $legacyUser['people_email_primary'],

            /** All fields available
             *  -----------------
            'id_people' => $legacyUser['id_people'],
            'name_first' => $legacyUser['name_first'],
            'name_last' => $legacyUser['name_last'],
            'people_email_primary' => $legacyUser['people_email_primary'],
            'name_middle' => $legacyUser['name_middle'],
            'name_preferred' => $legacyUser['name_preferred'],
            'name_spouse_first' => $legacyUser['name_spouse_first'],
            'name_spouse_last' => $legacyUser['name_spouse_last'],
            'address_street_1' => $legacyUser['address_street_1'],
            'address_street_2' => $legacyUser['address_street_2'],
            'address_city' => $legacyUser['address_city'],
            'address_state' => $legacyUser['address_state'],
            'address_zip' => $legacyUser['address_zip'],
            'address_country' => $legacyUser['address_country'],
            'address_county' => $legacyUser['address_county'],
            'address_access_instructions' => $legacyUser['address_access_instructions'],
            'people_geocode' => $legacyUser['people_geocode'],
            'people_geo_lat' => $legacyUser['people_geo_lat'],
            'people_geo_lng' => $legacyUser['people_geo_lng'],
            'people_email_secondary' => $legacyUser['people_email_secondary'],
            'people_phone_mobile' => $legacyUser['people_phone_mobile'],
            'people_phone_office' => $legacyUser['people_phone_office'],
            'people_phone_home' => $legacyUser['people_phone_home'],
            'people_gender' => $legacyUser['people_gender'],
            'people_dob' => $legacyUser['people_dob'],
            'home_church' => $legacyUser['home_church'],
            'id_home_church' => $legacyUser['id_home_church'],
            'id_church_add' => $legacyUser['id_church_add'],
            'url_avatar' => $legacyUser['url_avatar'],
            'url_avatar_one_pager' => $legacyUser['url_avatar_one_pager'],
            'is_affiliate_admin' => $legacyUser['is_affiliate_admin'],
            'state' => $legacyUser['state'],
            'state_last' => $legacyUser['state_last'],
            'date_add' => $legacyUser['date_add'],
            'date_mod' => $legacyUser['date_mod'],
            'date_sync' => $legacyUser['date_sync'],
            'date_removed' => $legacyUser['date_removed'],
            'password' => $legacyUser['password'],
            'id_add' => $legacyUser['id_add'],
            'id_mod' => $legacyUser['id_mod'],
            'id_removed' => $legacyUser['id_removed'],
            'date_self_update' => $legacyUser['date_self_update'],
            'date_last_login' => $legacyUser['date_last_login'],
            'pass_reset' => $legacyUser['pass_reset'],
            'pass_reset_force' => $legacyUser['pass_reset_force'],
            'interest_advocate' => $legacyUser['interest_advocate'],
            'interest_foster_family_respite' => $legacyUser['interest_foster_family_respite'],
            'interest_foster_family' => $legacyUser['interest_foster_family'],
            'interest_child_mentor' => $legacyUser['interest_child_mentor'],
            'interest_family_helper' => $legacyUser['interest_family_helper'],
            'interest_team_leader' => $legacyUser['interest_team_leader'],
            'interest_care_community' => $legacyUser['interest_care_community'],
            'interest_interim_caregiver' => $legacyUser['interest_interim_caregiver'],
            'interest_prayer' => $legacyUser['interest_prayer'],
            'interest_adoption' => $legacyUser['interest_adoption'],
            'interest_care_portal' => $legacyUser['interest_care_portal'],
            'interest_fam_custom_1' => $legacyUser['interest_fam_custom_1'],
            'interest_fam_custom_2' => $legacyUser['interest_fam_custom_2'],
            'interest_fam_custom_3' => $legacyUser['interest_fam_custom_3'],
            'interest_fam_custom_4' => $legacyUser['interest_fam_custom_4'],
            'interest_fam_custom_5' => $legacyUser['interest_fam_custom_5'],
            'interest_fam_custom_6' => $legacyUser['interest_fam_custom_6'],
            'interest_fam_custom_7' => $legacyUser['interest_fam_custom_7'],
            'interest_fam_custom_8' => $legacyUser['interest_fam_custom_8'],
            'interest_fam_custom_9' => $legacyUser['interest_fam_custom_9'],
            'interest_fam_custom_0' => $legacyUser['interest_fam_custom_0'],
            'age' => $legacyUser['age'],
            'date_birth' => $legacyUser['date_birth'],
            'date_anniversary' => $legacyUser['date_anniversary'],
            'has_cert_mentor' => $legacyUser['has_cert_mentor'],
            'cert_mentor_agency_ids' => $legacyUser['cert_mentor_agency_ids'],
            'has_cert_cpr' => $legacyUser['has_cert_cpr'],
            'cert_cpr_date_expire' => $legacyUser['cert_cpr_date_expire'],
            'vol_agree_sign_date' => $legacyUser['vol_agree_sign_date'],
            'vol_agree_sign_name' => $legacyUser['vol_agree_sign_name'],
            'id_salesforce' => $legacyUser['id_salesforce'],
            'id_salesforce_household' => $legacyUser['id_salesforce_household'],
            'id_org_internal' => $legacyUser['id_org_internal'],
            'id_import_batch' => $legacyUser['id_import_batch'],
            'geo_address_street' => $legacyUser['geo_address_street'],
            'geo_address_city' => $legacyUser['geo_address_city'],
            'geo_address_state' => $legacyUser['geo_address_state'],
            'geo_address_zip' => $legacyUser['geo_address_zip'],
            'geo_address_country' => $legacyUser['geo_address_country'],
            'id_churches_assigned' => $legacyUser['id_churches_assigned'],
            'key' => $legacyUser['key'],
            'agree_advocate_sign_name' => $legacyUser['agree_advocate_sign_name'],
            'agree_advocate_sign_date' => $legacyUser['agree_advocate_sign_date'],
            'agree_staff_sign_name' => $legacyUser['agree_staff_sign_name'],
            'agree_staff_sign_date' => $legacyUser['agree_staff_sign_date'],
            'agree_family_sign_name' => $legacyUser['agree_family_sign_name'],
            'agree_family_sign_date' => $legacyUser['agree_family_sign_date'],
            'params' => $legacyUser['params'],
            'cert_bg_check_agency' => $legacyUser['cert_bg_check_agency'],
            'cert_bg_check_church' => $legacyUser['cert_bg_check_church'],
            'cert_fingerprints' => $legacyUser['cert_fingerprints'],
            'cert_training_church' => $legacyUser['cert_training_church'],
            'cert_training_agency' => $legacyUser['cert_training_agency'],
            'cert_training_affiliate' => $legacyUser['cert_training_affiliate'],
            'cert_church_approval' => $legacyUser['cert_church_approval'],
            'contact_emergency' => $legacyUser['contact_emergency'],
            'force_logout' => $legacyUser['force_logout'],
            'currently_logged_in' => $legacyUser['currently_logged_in'],
            'can_login' => $legacyUser['can_login'],
            'login_key' => $legacyUser['login_key'],
            'has_portal_access' => $legacyUser['has_portal_access'],
            'edit_key' => $legacyUser['edit_key'],
            'edit_key_date_expire' => $legacyUser['edit_key_date_expire'],
            'auth_send_behalf' => $legacyUser['auth_send_behalf'],
            'time_zone' => $legacyUser['time_zone'],
            'id_place' => $legacyUser['id_place'],
            'entry_point' => $legacyUser['entry_point'],
            'occupation' => $legacyUser['occupation'],
            'affiliate_auth' => $legacyUser['affiliate_auth'],
            'obscure_name' => $legacyUser['obscure_name'],
            'people_title' => $legacyUser['people_title'],
            'people_status_text' => $legacyUser['people_status_text'],
            'session_time' => $legacyUser['session_time'],
            'index_name_first' => $legacyUser['index_name_first'],
            'notifications' => $legacyUser['notifications'],
            'has_cert_ff' => $legacyUser['has_cert_ff'],
            'cert_ff_agency_ids' => $legacyUser['cert_ff_agency_ids'],
            'username' => $legacyUser['username'],
            'cert_tb_screen_date' => $legacyUser['cert_tb_screen_date'],
            'contact_emergency_phone' => $legacyUser['contact_emergency_phone'],
            'cert_interview_date' => $legacyUser['cert_interview_date'],
            'people_languages' => $legacyUser['people_languages'],
            'people_languages_other' => $legacyUser['people_languages_other'],
            'use_assigned_status' => $legacyUser['use_assigned_status'],
            'conv_migrate_status' => $legacyUser['conv_migrate_status'],
             ***/

        ];
    }
}
