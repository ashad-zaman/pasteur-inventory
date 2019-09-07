<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Samples_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_samples()
    {
        return $this->db->get("xin_hrsale_sample");
    }

    public function get_samples_order_no()
    {
        $this->db->select('*');
        $this->db->from('xin_hrsale_sample');
        $this->db->order_by('sample_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0]->sample_id;
        } else {
            return null;
        }
    }
    public function read_samples_info($id)
    {

        $condition = "sample_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_hrsale_sample');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function read_sample_items_info($id)
    {

        $condition = "sample_item_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('xin_hrsale_sample_items');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_sample_items($id)
    {

        $sql = 'SELECT * FROM xin_hrsale_sample_items WHERE sample_id = ?';
        $binds = array($id);
        $query = $this->db->query($sql, $binds);

        return $query->result();
    }

    // Function to add record in table
    public function add_sample_record($data)
    {
        $this->db->insert('xin_hrsale_sample', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // Function to add record in table
    public function add_sample_items_record($data)
    {
        $this->db->insert('xin_hrsale_sample_items', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Function to Delete selected record from table
    public function delete_record($id)
    {
        $this->db->where('sample_id', $id);
        $this->db->delete('xin_hrsale_sample');

    }

    // Function to Delete selected record from table
    public function delete_sample_items($id)
    {
        $this->db->where('sample_id', $id);
        $this->db->delete('xin_hrsale_sample_items');

    }

    // Function to Delete selected record from table
    public function delete_sample_items_record($id)
    {
        $this->db->where('sample_item_id', $id);
        $this->db->delete('xin_hrsale_sample_items');

    }

    // Function to update record in table
    public function update_sample_record($data, $id)
    {
        $this->db->where('sample_id', $id);
        if ($this->db->update('xin_hrsale_sample', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // Function to update record in table
    public function update_sample_items_record($data, $id)
    {
        $this->db->where('sample_item_id', $id);
        if ($this->db->update('xin_hrsale_sample_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
