<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Challan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_challanes()
    {
        return $this->db->get("xin_hrsale_delivery_challan");
    }
    public function get_challan_order_no()
    {
        $this->db->select('*');
        $this->db->from('xin_hrsale_delivery_challan');
        $this->db->order_by('challan_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0]->challan_id;
        } else {
            return null;
        }
    }
    public function read_challan_info($id)
    {

        $condition = "challan_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_hrsale_delivery_challan');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function read_challan_items_info($id)
    {

        $condition = "challan_item_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_hrsale_delivery_challan_items');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_challan_items($id)
    {

        $sql = 'SELECT * FROM xin_hrsale_delivery_challan_items WHERE challan_id = ?';
        $binds = array($id);
        $query = $this->db->query($sql, $binds);

        return $query->result();
    }

    // Function to add record in table
    public function add_challan_record($data)
    {
        $this->db->insert('xin_hrsale_delivery_challan', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // Function to add record in table
    public function add_challan_items_record($data)
    {
        $this->db->insert('xin_hrsale_delivery_challan_items', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Function to Delete selected record from table
    public function delete_record($id)
    {
        $this->db->where('challan_id', $id);
        $this->db->delete('xin_hrsale_delivery_challan');

    }

    // Function to Delete selected record from table
    public function delete_challan_items($id)
    {
        $this->db->where('challan_id', $id);
        $this->db->delete('xin_hrsale_delivery_challan_items');

    }

    // Function to Delete selected record from table
    public function delete_challan_items_record($id)
    {
        $this->db->where('challan_item_id', $id);
        $this->db->delete('xin_hrsale_delivery_challan_items');

    }

    // Function to update record in table
    public function update_challan_record($data, $id)
    {
        $this->db->where('challan_id', $id);
        if ($this->db->update('xin_hrsale_delivery_challan', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // Function to update record in table
    public function update_challan_items_record($data, $id)
    {
        $this->db->where('challan_item_id', $id);
        if ($this->db->update('xin_hrsale_delivery_challan_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
