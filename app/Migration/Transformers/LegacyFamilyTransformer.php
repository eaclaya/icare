<?php

namespace App\Migration\Transformers;

class LegacyFamilyTransformer
{
    /**
     * transform
     *
     * @param array $legacyFamily
     * @return array
     */
    public static function transform(array $legacyFamily): array
    {
        return [
            'id' => $legacyFamily['id_family'],
            'name' => $legacyFamily['family_name'],
            'type' => $legacyFamily['family_type'],
            'structure' => $legacyFamily['family_structure'],

            /** All fields available
             *  -----------------
            'id_family' => $legacyFamily['id_family'],
            'family_name' => $legacyFamily['family_name'],
            'family_type' => $legacyFamily['family_type'],
            'family_structure' => $legacyFamily['family_structure'],
            'id_salesforce' => $legacyFamily['id_salesforce'],
            'state' => $legacyFamily['state'],
            'date_add' => $legacyFamily['date_add'],
            'date_mod' => $legacyFamily['date_mod'],
            'date_removed' => $legacyFamily['date_removed'],
            'date_sync' => $legacyFamily['date_sync'],
            'id_add' => $legacyFamily['id_add'],
            'id_mod' => $legacyFamily['id_mod'],
            'id_church_recruited' => $legacyFamily['id_church_recruited'],
            'id_church_home' => $legacyFamily['id_church_home'],
            'id_church_add' => $legacyFamily['id_church_add'],
            'id_church_claim' => $legacyFamily['id_church_claim'],
            'id_church_serving' => $legacyFamily['id_church_serving'],
            'id_church_refer' => $legacyFamily['id_church_refer'],
            'id_people_primary' => $legacyFamily['id_people_primary'],
            'status_foster' => $legacyFamily['status_foster'],
            'status_adoption' => $legacyFamily['status_adoption'],
            'status_bio' => $legacyFamily['status_bio'],
            'previously_served_on_cc' => $legacyFamily['previously_served_on_cc'],
            'previously_fostered' => $legacyFamily['previously_fostered'],
            'recruited_by_church' => $legacyFamily['recruited_by_church'],
            'recruited_by_affiliate' => $legacyFamily['recruited_by_affiliate'],
            'url_avatar' => $legacyFamily['url_avatar'],
            'id_org_internal' => $legacyFamily['id_org_internal'],
            'id_import_batch' => $legacyFamily['id_import_batch'],
            'requestor_name_first' => $legacyFamily['requestor_name_first'],
            'requestor_name_last' => $legacyFamily['requestor_name_last'],
            'requestor_phone' => $legacyFamily['requestor_phone'],
            'requestor_email' => $legacyFamily['requestor_email'],
            'requestor_relationship' => $legacyFamily['requestor_relationship'],
            'requestor_id_church' => $legacyFamily['requestor_id_church'],
            'family_geo_lat' => $legacyFamily['family_geo_lat'],
            'family_geo_lng' => $legacyFamily['family_geo_lng'],
            'has_past_adopted' => $legacyFamily['has_past_adopted'],
            'has_past_fostered' => $legacyFamily['has_past_fostered'],
            'has_past_kinship_placement' => $legacyFamily['has_past_kinship_placement'],
            'has_current_kinship_placement' => $legacyFamily['has_current_kinship_placement'],
            'has_current_foster_placement' => $legacyFamily['has_current_foster_placement'],
            'has_desire_adopt' => $legacyFamily['has_desire_adopt'],
            'has_desire_foster' => $legacyFamily['has_desire_foster'],
            'has_desire_kinship' => $legacyFamily['has_desire_kinship'],
            'params' => $legacyFamily['params'],
            'agree_family_sign_name' => $legacyFamily['agree_family_sign_name'],
            'agree_family_sign_date' => $legacyFamily['agree_family_sign_date'],
            'edit_key' => $legacyFamily['edit_key'],
            'edit_key_date_expire' => $legacyFamily['edit_key_date_expire'],
            'id_place' => $legacyFamily['id_place'],
            'id_churches_nearby' => $legacyFamily['id_churches_nearby'],
            'entry_point' => $legacyFamily['entry_point'],
            'family_languages' => $legacyFamily['family_languages'],
            'family_languages_other' => $legacyFamily['family_languages_other'],
            'name_parent0_first' => $legacyFamily['name_parent0_first'],
            'name_parent0_last' => $legacyFamily['name_parent0_last'],
            'name_parent1_first' => $legacyFamily['name_parent1_first'],
            'name_parent1_last' => $legacyFamily['name_parent1_last'],
            'name_parent2_first' => $legacyFamily['name_parent2_first'],
            'name_parent2_last' => $legacyFamily['name_parent2_last'],
            'name_parent3_last' => $legacyFamily['name_parent3_last'],
            'name_parent3_first' => $legacyFamily['name_parent3_first'],
            'access_instructions' => $legacyFamily['access_instructions'],
            'id_community_active' => $legacyFamily['id_community_active'],
            'id_community_last' => $legacyFamily['id_community_last'],
            'date_foster_start' => $legacyFamily['date_foster_start'],
             **/

        ];
    }
}
