<?php

class Customer extends CI_Model {

    /*
    return all Customerss.
    created by your name
    created at 30-06-20.
    */
    public function getAll() {
        return $this->db->get('customers')->result();
    }

    public function getActive() {
        $this->db->where('outstandingBalance >=', 0);
        return $this->db->get('customers')->result();
    }

    public function getTotalBalance() {
        

        //$this->db->where('accName !=', 'factory');
        $this->db->select('SUM(outstandingBalance) as sum1');

        return $this->db->get('customers')->result();
    }
    public function getLedgerCustomer($Customer){
        $q = "SELECT  transactions1.transId,transactions1.ref, transactions1.cust_name, transactions1.itemCode as 'name', transactions1.unitPrice as 'price', transactions1.quantity as 'qty', transactions1.totalPrice as 'amount', (transactions1.amountTendered - transactions1.changeDue) as 'cash', transactions1.invoiceTotal,  transactions1.transDate, 'link','sale' as 'tableName' FROM transactions1 WHERE transactions1.cust_name = ?
UNION All
SELECT accountTransactions.transId, accountTransactions.type, accountTransactions.type,accountTransactions.description as 'desc', accountTransactions.referenceNo,  accountTransactions.creditAmount, accountTransactions.debitAmount, accountTransactions.transactionDate, accountTransactions.transactionDate, accountTransactions.transactionDate,accountTransactions.hlink, 'cash' as 'tableName' FROM accountTransactions
WHERE accountTransactions.type = 'customer' AND accountTransactions.referenceNo = ?
UNION ALL
SELECT  returnTransactions.transId, returnTransactions.returnRef, returnTransactions.cust_name, returnTransactions.itemName as 'name', returnTransactions.unitPrice as 'costPrice', returnTransactions.quantity as 'qty', returnTransactions.totalPrice as 'amount',  returnTransactions.amountPayable, returnTransactions.invoiceTotal, returnTransactions.transDate,'link', 'return' as 'tableName' FROM returnTransactions WHERE returnTransactions.cust_name = ?
ORDER BY transDate ASC, ref ASC";
        
        $run_q = $this->db->query($q, [$Customer, $Customer, $Customer]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }

    }
    /*
    function for create Customers.
    return Customers inserted id.
    created by your name
    created at 30-06-20.
    */
    public function insert($data) {
        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }
    /*
    return Customers by id.
    created by your name
    created at 30-06-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('customers')->result();
    }
    /*
    function for update Customers.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('customers', $data);
        return true;
    }
    /*
    function for delete Customers.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('customers');
        return true;
    }
    /*
    function for change status of Customers.
    return activated of deactivated.
    created by your name
    created at 30-06-20.
    */
    public function changeStatus($id) {
        $table=$this->getDataById($id);
             if($table[0]->status==0)
             {
                $this->update($id,array('status' => '1'));
                return "Activated";
             }else{
                $this->update($id,array('status' => '0'));
                return "Deactivated";
             }
    }

    public function getCustomerInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('customers');
        
        return $run_q->num_rows() ? $run_q->row() : FALSE;
    }

}