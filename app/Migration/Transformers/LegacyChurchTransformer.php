<?php 

namespace App\Migration\Transformers;

class LegacyChurchTransformer
{
    /**
     * transform
     *
     * @param array $legacyChurch
     * @return array
     */
    public static function transform(array $legacyChurch): array
    {
        return [
            'id' => $legacyChurch['id_church'],
            'name' => $legacyChurch['church_name'],
            'nickname' => $legacyChurch['church_nick'],
            'campus_name' => $legacyChurch['campus_name'],

            /** All fields available
             *  -----------------
            'id_church' => $legacyChurch['id_church'],
            'church_name' => $legacyChurch['church_name'],
            'church_nick' => $legacyChurch['church_nick'],
            'campus_name' => $legacyChurch['campus_name'],
            'address_street_1' => $legacyChurch['address_street_1'],
            'address_street_2' => $legacyChurch['address_street_2'],
            'address_city' => $legacyChurch['address_city'],
            'address_state' => $legacyChurch['address_state'],
            'address_zip' => $legacyChurch['address_zip'],
            'address_county' => $legacyChurch['address_county'],
            'address_country' => $legacyChurch['address_country'],
            'church_geocode' => $legacyChurch['church_geocode'],
            'church_geo_lat' => $legacyChurch['church_geo_lat'],
            'church_geo_lng' => $legacyChurch['church_geo_lng'],
            'church_website' => $legacyChurch['church_website'],
            'phone' => $legacyChurch['phone'],
            'church_contact_name' => $legacyChurch['church_contact_name'],
            'church_contact_email' => $legacyChurch['church_contact_email'],
            'is_campus' => $legacyChurch['is_campus'],
            'id_church_parent' => $legacyChurch['id_church_parent'],
            'is_anchor_church' => $legacyChurch['is_anchor_church'],
            'is_satelite_church' => $legacyChurch['is_satelite_church'],
            'state' => $legacyChurch['state'],
            'date_add' => $legacyChurch['date_add'],
            'date_mod' => $legacyChurch['date_mod'],
            'date_removed' => $legacyChurch['date_removed'],
            'date_start' => $legacyChurch['date_start'],
            'date_end' => $legacyChurch['date_end'],
            'date_sync' => $legacyChurch['date_sync'],
            'date_admin' => $legacyChurch['date_admin'],
            'id_add' => $legacyChurch['id_add'],
            'id_mod' => $legacyChurch['id_mod'],
            'id_removed' => $legacyChurch['id_removed'],
            'id_admin' => $legacyChurch['id_admin'],
            'id_salesforce' => $legacyChurch['id_salesforce'],
            'id_salesforce_record_type' => $legacyChurch['id_salesforce_record_type'],
            'id_import_batch' => $legacyChurch['id_import_batch'],
            'partner_type' => $legacyChurch['partner_type'],
            'church_denomination' => $legacyChurch['church_denomination'],
            'geo_address_street' => $legacyChurch['geo_address_street'],
            'geo_address_city' => $legacyChurch['geo_address_city'],
            'geo_address_state' => $legacyChurch['geo_address_state'],
            'geo_address_zip' => $legacyChurch['geo_address_zip'],
            'geo_address_country' => $legacyChurch['geo_address_country'],
            'church_county' => $legacyChurch['church_county'],
            'is_affiliate_church' => $legacyChurch['is_affiliate_church'],
            'id_batch' => $legacyChurch['id_batch'],
            'id_org_internal' => $legacyChurch['id_org_internal'],
            'params' => $legacyChurch['params'],
            'church_name_alts' => $legacyChurch['church_name_alts'],
            'disable_volunteer_sharing' => $legacyChurch['disable_volunteer_sharing'],
            'church_requires_training' => $legacyChurch['church_requires_training'],
            'church_type_ltp' => $legacyChurch['church_type_ltp'],
            'church_type_resource' => $legacyChurch['church_type_resource'],
            'church_type_careportal' => $legacyChurch['church_type_careportal'],
            'edit_key' => $legacyChurch['edit_key'],
            'church_type' => $legacyChurch['church_type'],
            'id_place' => $legacyChurch['id_place'],
            'church_map_eligible' => $legacyChurch['church_map_eligible'],
            'church_hash' => $legacyChurch['church_hash'],
            'fam_name' => $legacyChurch['fam_name'],
            'index_church_name' => $legacyChurch['index_church_name'],
            'index_campus_name' => $legacyChurch['index_campus_name'],
            'index_church_denom' => $legacyChurch['index_church_denom'],
            'index_church_index' => $legacyChurch['index_church_index'],
            'omit_from_church_count' => $legacyChurch['omit_from_church_count'],
            'min_access_level' => $legacyChurch['min_access_level'],
            'entry_point' => $legacyChurch['entry_point'],
            'id_signature' => $legacyChurch['id_signature'],
            'church_slug' => $legacyChurch['church_slug'],
            'id_careportal' => $legacyChurch['id_careportal'],
            'activity_count' => $legacyChurch['activity_count'],
            'church_demographic' => $legacyChurch['church_demographic'],
            'mailing_address' => $legacyChurch['mailing_address'],
            'id_usachurch' => $legacyChurch['id_usachurch'],
            ***/

        ];
    }
}
