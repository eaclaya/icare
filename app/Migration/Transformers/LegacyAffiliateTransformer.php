<?php

namespace App\Migration\Transformers;

class LegacyAffiliateTransformer
{
    /**
     * transform
     *
     * @param array $legacyAffiliate
     * @return array
     */
    public static function transform(array $legacyAffiliate): array
    {
        return [
            'id' => $legacyAffiliate['id_affiliate'],
            'name' => $legacyAffiliate['affiliate_name'],
            'description' => $legacyAffiliate['affiliate_desc'],
            'contact_name' => $legacyAffiliate['affiliate_contact_name'],
            'contact_email' => $legacyAffiliate['affiliate_contact_email'],
            'contact_phone' => $legacyAffiliate['afflliate_contact_phone'],

            /** All fields available
             *  ----------------- 
            'id_affiliate' => $legacyAffiliate['id_affiliate'],
            'affiliate_name' => $legacyAffiliate['affiliate_name'],
            'affiliate_desc' => $legacyAffiliate['affiliate_desc'],
            'affiliate_contact_name' => $legacyAffiliate['affiliate_contact_name'],
            'affiliate_contact_email' => $legacyAffiliate['affiliate_contact_email'],
            'afflliate_contact_phone' => $legacyAffiliate['afflliate_contact_phone'],
            'affiliate_address_street' => $legacyAffiliate['affiliate_address_street'],
            'affiliate_address_city' => $legacyAffiliate['affiliate_address_city'],
            'affiliate_address_state' => $legacyAffiliate['affiliate_address_state'],
            'affiliate_address_zip' => $legacyAffiliate['affiliate_address_zip'],
            'affiliate_address_country' => $legacyAffiliate['affiliate_address_country'],
            'url_avatar' => $legacyAffiliate['url_avatar'],
            'state' => $legacyAffiliate['state'],
            'date_add' => $legacyAffiliate['date_add'],
            'date_mod' => $legacyAffiliate['date_mod'],
            'date_removed' => $legacyAffiliate['date_removed'],
            'date_start' => $legacyAffiliate['date_start'],
            'date_sync' => $legacyAffiliate['date_sync'],
            'id_add' => $legacyAffiliate['id_add'],
            'id_mod' => $legacyAffiliate['id_mod'],
            'id_removed' => $legacyAffiliate['id_removed'],
            'id_salesforce' => $legacyAffiliate['id_salesforce'],
            'affiliate_phone' => $legacyAffiliate['affiliate_phone'],
            'affiliate_subdomain' => $legacyAffiliate['affiliate_subdomain'],
            'affiliate_style_settings' => $legacyAffiliate['affiliate_style_settings'],
            'affiliate_agree_volunteer' => $legacyAffiliate['affiliate_agree_volunteer'],
            'affiliate_agree_family' => $legacyAffiliate['affiliate_agree_family'],
            'affiliate_agree_advocate' => $legacyAffiliate['affiliate_agree_advocate'],
            'affiliate_agree_staff' => $legacyAffiliate['affiliate_agree_staff'],
            'allow_interest_care_portal' => $legacyAffiliate['allow_interest_care_portal'],
            'restrict_cross_church_volunteers' => $legacyAffiliate['restrict_cross_church_volunteers'],
            'default_search_radius' => $legacyAffiliate['default_search_radius'],
            'allow_foster_family_home_types' => $legacyAffiliate['allow_foster_family_home_types'],
            'allow_volunteer_compliance_fields' => $legacyAffiliate['allow_volunteer_compliance_fields'],
            'params' => $legacyAffiliate['params'],
            'allow_community_name_edit_on_new' => $legacyAffiliate['allow_community_name_edit_on_new'],
            'allow_family_name_edit_on_new' => $legacyAffiliate['allow_family_name_edit_on_new'],
            'enable_regions' => $legacyAffiliate['enable_regions'],
            'id_agency' => $legacyAffiliate['id_agency'],
            'id_place' => $legacyAffiliate['id_place'],
            'is_anchor' => $legacyAffiliate['is_anchor'],
            'affiliate_website' => $legacyAffiliate['affiliate_website'],
            'affiliate_name_short' => $legacyAffiliate['affiliate_name_short'],
            'is_promise_network_partner' => $legacyAffiliate['is_promise_network_partner'],
            'affiliate_time_zone' => $legacyAffiliate['affiliate_time_zone'],
            'affiliate_css' => $legacyAffiliate['affiliate_css'],
            'disable_resources' => $legacyAffiliate['disable_resources'],
            'is_network_recruiter' => $legacyAffiliate['is_network_recruiter'],
            'allowed_apps' => $legacyAffiliate['allowed_apps'], 
         */
        ];
    }
}
