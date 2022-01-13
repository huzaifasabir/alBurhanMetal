<?php
defined('BASEPATH') OR exit(':D');


class Analytic extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /**
     * Get daily info on transactions
     * @param type $start
     * @param type $limit
     * @param type $order_by
     * @param type $order_format
     * @return boolean
     */
    public function getDailyTrans($start=0, $limit=10, $order_by='DATE(transDate)', $order_format='DESC'){
        $this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", sum(totalPrice) as "tot_earned", transDate');
        $this->db->order_by($order_by, $order_format);
        $this->db->limit($limit, $start);
        $this->db->group_by('DATE(transDate)');
        
        $run_q = $this->db->get('transactions1');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }   
    
    
    
    /*public function getTimeOfDay(){
        $this->db->select('count(id) as "counter", visit_period');
        $this->db->order_by('counter', 'DESC');
        $this->db->group_by('visit_period');
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    public function getTotalToday(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('DATE(visit_time)', date('Y-m-d'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    public function getTotalThisMonth(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('MONTH(visit_time)', date('n'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    
    
    public function getTotalThisYear(){
        $this->db->select('count(id) as "counter"');
        $this->db->where('YEAR(visit_time)', date('Y'));
        
        $run_q = $this->db->get('daily_visitors');
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->counter;
            }
        }
        
        else{
            return FALSE;
        }
    }*/
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    /**
     * Get Transactions info by days
     * @return boolean
     */
    public function getTransByDays(){
        if($this->db->platform() == "sqlite3" ){
            $q = "SELECT 
                count(DISTINCT(ref)) as 'tot_trans', 
                SUM(quantity) as 'qty_sold', 
                SUM(totalPrice) as 'tot_earned',
                case cast (strftime('%w', transDate) as integer)
                  when 0 then 'Sunday'
                  when 1 then 'Monday'
                  when 2 then 'Tuesday'
                  when 3 then 'Wednesday'
                  when 4 then 'Thursday'
                  when 5 then 'Friday'
                  else 'Saturday' end as day
              FROM transactions
              GROUP BY day
              ORDER BY tot_earned DESC";
              
          $run_q = $this->db->query($q, []);
        }
        
        
        else{

            //$q = "select count(temp.tot_trans1) as 'tot_trans', SUM(temp.qty_sold1) as 'qty_sold', sum(temp.tot_earned1) as 'tot_earned', temp.day from (select count(DISTINCT(ref)) as 'tot_trans1', SUM(quantity) as 'qty_sold1', totalProfit as 'tot_earned1', DAYNAME(transDate) as 'day' from transactions1 GROUP BY transactions1.ref  ) as temp GROUP BY temp.day ORDER BY temp.tot_earned DESC LIMIT 5";

            $this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", sum(totalPrice) as "tot_earned", DAYNAME(transDate) as "day"');
            $this->db->order_by('tot_earned', 'DESC');
            //$this->db->group_by('ref');
            $this->db->group_by('day');
            $run_q = $this->db->get('transactions1');
            //$run_q = $this->db->query($q);

        
        }
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        else{
            return FALSE;
        }
    }
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    /**
     * Get Transactions info by months
     * @return boolean
     */
    public function getTransByMonths(){
        if($this->db->platform() == "sqlite3"){
            $q = "SELECT 
                count(DISTINCT(ref)) as 'tot_trans', 
                SUM(quantity) as 'qty_sold', 
                SUM(totalPrice) as 'tot_earned',
                case cast (strftime('%m', transDate) as integer)
                  when 01 then 'January'
                  when 02 then 'February'
                  when 03 then 'March'
                  when 04 then 'April'
                  when 05 then 'May'
                  when 06 then 'June'
                  when 07 then 'July'
                  when 08 then 'August'
                  when 09 then 'September'
                  when 10 then 'October'
                  when 11 then 'November'
                  when 12 then 'December' end as month
              FROM transactions
              GROUP BY month
              ORDER BY tot_earned DESC";
              
          $run_q = $this->db->query($q, []);
        }
        
        
        else{
            $this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", MONTHNAME(transDate) as "month"');
            $this->db->order_by('tot_earned', 'DESC');
            $this->db->group_by('month');
        
            $run_q = $this->db->get('transactions1');
        }
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    /**
     * Get Transactions info by years
     * @return boolean
     */
    public function getTransByYears(){
        if($this->db->platform() == "sqlite3" ){
            $q = "SELECT 
                count(DISTINCT(ref)) as 'tot_trans', 
                SUM(quantity) as 'qty_sold', 
                SUM(totalPrice) as 'tot_earned',
                strftime('%Y', transDate) as 'year'
              FROM transactions
              GROUP BY year
              ORDER BY tot_earned DESC";
              
          $run_q = $this->db->query($q, []);
        }
        
        
        else{
            $this->db->select('count(DISTINCT(ref)) as "tot_trans", SUM(quantity) as "qty_sold", SUM(totalPrice) as "tot_earned", YEAR(transDate) as "year"');
            $this->db->order_by('tot_earned', 'DESC');
            $this->db->group_by('year');
            
            $run_q = $this->db->get('transactions1');
        }
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    

    //lowest quantity items
    public function lowQuantity(){
        $q = "SELECT name, quantity as 'qty' FROM products WHERE quantity < 5
                 ORDER BY description ASC";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    /**
    * Selects most bought items
    * @return boolean
    */
    public function topDemanded(){
        $q = "SELECT products.name, SUM(transactions1.quantity) as 'totSold' FROM products 
                INNER JOIN transactions1 ON products.code=transactions1.itemCode GROUP BY transactions1.itemCode ORDER BY totSold DESC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
   
    public function stockR($from, $to){
        $q = "SELECT products.name, products.subCategory, SUM(transactions1.quantity) as 'totalSold', AVG(transactions1.unitPrice) as 'averagePrice', products.costPrice, SUM(((transactions1.unitPrice) - (transactions1.costUnitPrice)) * (transactions1.quantity)) as 'totalProfit'  FROM products 
                INNER JOIN transactions1 ON products.code=transactions1.itemCode WHERE Date(transDate) >= ? AND Date(transDate) <= ? GROUP BY transactions1.itemCode ORDER BY products.subCategory, totalSold DESC";
        $run_q = $this->db->query($q,[$from, $to]);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
    public function stockRr($from, $to){
        $q = "SELECT products.name, products.subCategory, SUM(returnTransactions.quantity) as 'totalSold', AVG(returnTransactions.unitPrice) as 'averagePrice', products.costPrice, SUM(((returnTransactions.unitPrice) - (returnTransactions.costUnitPrice)) * (returnTransactions.quantity)) as 'totalProfit'  FROM products 
                INNER JOIN returnTransactions ON products.code=returnTransactions.itemCode WHERE Date(transDate) >= ? AND Date(transDate) <= ? GROUP BY returnTransactions.itemCode ORDER BY products.subCategory, totalSold DESC";
        $run_q = $this->db->query($q,[$from, $to]);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
   
   
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */

    /**
     * Selects least bought items
     * @return boolean
     */
    public function leastDemanded(){
        $q = "SELECT products.name, SUM(transactions1.quantity) as 'totSold' FROM products 
                INNER JOIN transactions1 ON products.code=transactions1.itemCode GROUP BY transactions1.itemCode ORDER BY totSold ASC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }


    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */

    /**
     * Items that has brought highest income (in total)
     * @return boolean
     */
    public function highestEarners(){
        $q = "SELECT products.name, SUM(transactions1.totalPrice) as 'totEarned', SUM(transactions1.totalCostPrice) as 'cost' FROM products 
                INNER JOIN transactions1 ON products.code=transactions1.itemCode 
                GROUP BY transactions1.itemCode 
                ORDER BY totEarned DESC LIMIT 5";

        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }


   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
   /**
    * Items that has brought lowest income (in total)
    * @return boolean
    */
    public function lowestEarners(){
        $q = "SELECT products.name, SUM(transactions1.totalPrice) as 'totEarned', SUM(transactions1.totalCostPrice) as 'cost' FROM products 
                INNER JOIN transactions1 ON products.code=transactions1.itemCode 
                GROUP BY transactions1.itemCode 
                ORDER BY totEarned ASC LIMIT 5";

       
        $run_q = $this->db->query($q);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
    
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * selects all transactions done within the last 24hrs
     * @return boolean
     */
    public function totalSalesToday(){
        $q = "SELECT SUM(quantity) as 'totalTransToday' FROM transactions1 WHERE DATE(transDate) = CURRENT_DATE";
       
        $run_q = $this->db->query($q);
       
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->totalTransToday;
            }
        }

        else{
            return FALSE;
        }
    }
}
