<?php

class AccountsTransaction extends CI_Model {

    /*
    return all Accountss.
    created by your name
    created at 30-06-20.
    */
    public function getAll() {
        return $this->db->get('accounts')->result();
    }

    public function getAllTrans($orderBy, $orderFormat, $start, $limit) {
        //$this->db->where('referenceNo',$);
        $this->db->limit($limit, $start);
        //$this->db->group_by('ref');
        $this->db->order_by($orderBy, $orderFormat);
        return $this->db->get('accountTransactions')->result();   
    }
    /*
    function for create Accounts.
    return Accounts inserted id.
    created by your name
    created at 30-06-20.
    */

    public function cashTransSearch1($value) {
        
            
                
        
        $this->db->where('transId', $value);
        //$this->db->or_like('Date(transDate)', $value);
        //$this->db->or_like('itemCode', $value);
        //$this->db->or_like('transDate', $value);
        //$this->db->or_like('transactions1.quantity', $value);
        //$this->db->group_by('ref');

        $run_q = $this->db->get('accountTransactions');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function totalTransactions() {
        $q = "SELECT count(DISTINCT transId) as 'totalTrans' FROM accountTransactions";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalTrans;
            }
        }
        else {
            return FALSE;
        }
    }

    public function getRentReport($from, $to, $shop) {
        //$this->db->where('(transactionDate) >=',$from);
        //$this->db->where('(transactionDate) <=',$to);
        $this->db->where('referenceNo', $shop);
        $where = " transactionDate >= '".$from."' AND transactionDate <= '".$to."'";
        $this->db->where($where);
        $this->db->order_by('transactionDate', 'ASC');
        //$this->db->select('SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function insert($data) {
        $this->db->insert('accountTransactions', $data);
        
        return $this->db->insert_id();
    }
    public function updateTransaction($transId,$data) {
        $this->db->where('transId', $transId);
        $this->db->update('accountTransactions', $data);
        return true;
    }
    public function deleteTransaction($transId) {
        $this->db->where('transId', $transId);
        $this->db->delete('accountTransactions');
        return true;
    }
    public function deleteTransaction1($ref,$type) {
        $this->db->where('referenceNo', $ref);
        $this->db->where('type', $type);
        $this->db->delete('accountTransactions');
        return true;
    }


    public function getTransactionId($ref, $type){
        $this->db->where('referenceNo', $ref);
        $this->db->where('type', $type);
        $this->db->select('transId');
        return $this->db->get('accountTransactions')->result();
    }
    /*
    return Accounts by id.
    created by your name
    created at 30-06-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('accounts')->result();
    }
    public function getTransDataById($id) {
        $this->db->where('transId', $id);
        return $this->db->get('accountTransactions')->result();
    }


    public function getDailyIncoming($date) {
        $this->db->where('transactionDate', $date);
        $this->db->where('debitAmount', NULL);
        $this->db->where('type !=','productsSold');
        $this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getDailyCash($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'productsSold' OR type='customer') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getHardwareCash($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(referenceNo = 'hardware' OR referenceNo = 'hardwareExpense') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit, SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getHomeExpenseDaily($date) {
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'homeExpense') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select(' SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getGolaCash($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(referenceNo = 'gola' OR referenceNo = 'golaExpense') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit, SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getPvcCash($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'pvcDoor') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit, SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getRentCash($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'rent') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getHattarDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(referenceNo = 'HP Hattar' OR referenceNo = 'QW Bhalwal') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        //$this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getHomeCashDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(referenceNo = 'Fazle Abbass' OR referenceNo = 'Muffaddal' OR referenceNo = 'Lamak') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        //$this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getPettyCashDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'petty') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(creditAmount) as sumCredit, SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getBankDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type='account' OR type='payable' OR type='receivable') AND (referenceNo != 'Fazle Abbass' AND referenceNo != 'Muffaddal' AND referenceNo != 'Lamak' AND referenceNo != 'HP Hattar' AND referenceNo != 'QW Bhalwal') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        //$this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getVendorDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "type='vendor' AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        //$this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getTransportLaborDaily($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type='labor' OR type='transport') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(debitAmount) as sumdebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getDailyCashMinus($date) {
        
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'productReturned' OR type='customer') AND transactionDate = '".$date."'";
        $this->db->where($where);
        //$this->db->where('transactionDate', $date);
        $this->db->select('SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getCashReport($from, $to) {
        //$this->db->where('(transactionDate) >=',$from);
        //$this->db->where('(transactionDate) <=',$to);
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'productsSold' OR type='customer') AND transactionDate >= '".$from."' AND transactionDate <= '".$to."'";
        //$where = "type='customer'";
        $this->db->where($where);
        $this->db->select('SUM(creditAmount) as sumCredit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }
    public function getCashMinusReport($from, $to) {
        //$this->db->where('(transactionDate) >=',$from);
        //$this->db->where('(transactionDate) <=',$to);
        //$this->db->where('debitAmount', NULL);
        $where = "(type = 'productReturned' OR type='customer') AND transactionDate >= '".$from."' AND transactionDate <= '".$to."'";
        $this->db->where($where);
        $this->db->select('SUM(debitAmount) as sumDebit');
        //$this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function getExpense($from, $to) {
        $this->db->where('Date(transactionDate) >=',$from);
        $this->db->where('Date(transactionDate) <=',$to);
        //$this->db->where('transactionDate', $date);
        $where = "type='shopExpense'";
        //$where1 = "referenceNo != 'gola' OR referenceNo!='hardware'";

        $this->db->where($where);
        //$this->db->where($where1);

        $this->db->select('SUM(debitAmount) as sum1');
        //$this->db->where('debitAmount', NULL);
        //$this->db->where('type !=','productsSold');
        return $this->db->get('accountTransactions')->result();
    }

    public function getExpenseByDate($date) {
        $this->db->where('Date(transactionDate)',$date);
        //$this->db->where('transactionDate', $date);
        $where = "type='shopExpense' ";
        //$where1 = "referenceNo != 'gola' OR referenceNo!='hardware'";

        $this->db->where($where);
        //$this->db->where($where1);

        $this->db->select('SUM(debitAmount) as sum1, referenceNo, type, description');
        $this->db->group_by('referenceNo');
        //$this->db->where('debitAmount', NULL);
        //$this->db->where('type !=','productsSold');
        return $this->db->get('accountTransactions')->result();
    }
    public function getExpenseDetails($from, $to) {
        $this->db->where('Date(transactionDate) >=',$from);
        $this->db->where('Date(transactionDate) <=',$to);
        //$this->db->where('transactionDate', $date);
        $where = "type='shopExpense'";
        //$where1 = "referenceNo != 'gola' OR referenceNo!='hardware' &&";

        $this->db->where($where);
        //$this->db->where($where1);

        $this->db->select('SUM(debitAmount) as sum1, referenceNo, type, description');
        $this->db->group_by('referenceNo');
        //$this->db->where('debitAmount', NULL);
        //$this->db->where('type !=','productsSold');
        return $this->db->get('accountTransactions')->result();
    }

    public function getDailyOutgoing($date) {
        $this->db->where('transactionDate', $date);
        $this->db->where('creditAmount', NULL);
        $this->db->order_by('transId', 'ASC');
        return $this->db->get('accountTransactions')->result();
    }

    public function vendorTransactions($vendor) {
        $this->db->where('referenceNo', $vendor);
        $this->db->where('type','vendor');
        //$this->db->where('creditAmount', NULL);
        return $this->db->get('accountTransactions')->result();
    }
    public function customerTransactions($customer) {
        $this->db->where('referenceNo', $customer);
        $this->db->where('type','customer');
        //$this->db->where('creditAmount', NULL);
        return $this->db->get('accountTransactions')->result();
    }
    public function accountTrans($account) {
        $this->db->where('referenceNo', $account);
        $this->db->order_by('transactionDate', 'ASC');
        //$this->db->where('creditAmount', NULL);
        return $this->db->get('accountTransactions')->result();
    }
    public function accountTrans1($account) {
        $q = "(type = 'account' OR type = 'payable' OR type = 'receivable' OR type = 'pvcDoor')";
        $this->db->where('referenceNo', $account);
        $this->db->where($q);
        $this->db->order_by('transactionDate', 'ASC');
        $this->db->order_by('transId', 'ASC');
        //$this->db->where('creditAmount', NULL);
        return $this->db->get('accountTransactions')->result();
    }

    public function cashInHandTrans($account) {
        $this->db->where('accName', $account);
        //$this->db->where('creditAmount', NULL);
        return $this->db->get('accountTransactions')->result();
    }

    /*
    function for update Accounts.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
        return true;
    }
    /*
    function for delete Accounts.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('accounts');
        return true;
    }
    /*
    function for change status of Accounts.
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

}