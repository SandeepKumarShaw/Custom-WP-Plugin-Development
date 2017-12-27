<?php

class MM_WPFS_Members_Database
{
    public static function setup_db()
    {
        //require for dbDelta()
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;

        $table = $wpdb->prefix . 'fullstripe_members';

        $sql = "CREATE TABLE " . $table . " (
        memberID INT NOT NULL AUTO_INCREMENT,
        role VARCHAR(100) NOT NULL,
        plan VARCHAR(100) NOT NULL,
        email VARCHAR(500) NOT NULL,
        wpUserID INT NOT NULL,
        stripeCustomerID VARCHAR(100),
        stripeSubscriptionID VARCHAR(100),
        stripeSubscriptionStatus VARCHAR(100),
        livemode TINYINT(1) DEFAULT 1,
        created DATETIME NOT NULL,
        UNIQUE KEY memberID (memberID)
        );";

        //database write/update
        dbDelta($sql);
    }

    public function insert_member($member)
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'fullstripe_members', $member);
        return $wpdb->insert_id;
    }

    function update_member($id, $member)
    {
        global $wpdb;
        $wpdb->update($wpdb->prefix . 'fullstripe_members', $member, array('memberID' => $id));
    }

    public function get_member($id)
    {
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "fullstripe_members WHERE memberID='" . $id . "';");
    }

    public function get_member_by_wpid($id)
    {
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "fullstripe_members WHERE wpUserID='" . $id . "';");
    }

    public function get_member_by_email($email)
    {
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "fullstripe_members WHERE email='" . $email . "';");
    }

    public function get_members()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "fullstripe_members;");
    }

}