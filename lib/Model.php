<?php

abstract class Model {

    protected $conn;

    const MYSQL_DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    const MYSQL_DATE_FORMAT = 'Y-m-d';
    const MYSQL_TIME_FORMAT = 'H:i:s';
    
    public static $TOTAL_RECORD_COUNT = 0; // used by pagination

    public function __construct($databaseName = DATABASE_NAME) {

        $dsn = CONN_DRIVER . ':dbname=' . $databaseName . ';host=' . CONN_HOST;
        try {
            $this->conn = new PDO($dsn, CONN_USER, CONN_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    /**
     * Get record from any table based on primary key id
     * @param string $table name of the table
     * @param integer $id auto-increamnt id of record
     * @param array $columns list of the colunms want to fetch
     * @return array record fetched from table
     */
    public function getRecordById($table, $id, array $columns = ['id']) {
        $sql = "SELECT " . implode(',', $columns) . " FROM $table WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get record from any table with conditions
     * @param string $table name of the table
     * @param array $coditions columns value pair of conditions
     * @param array $columns list of the colunms want to fetch
     * @return array record fetched from table
     */
    public function getRecords(array $columns, $table, array $coditions = [], $orderBy = '') {
        
        $columns[] = 'id'; // as id columns as mandetory for all records
        
        $sql = "SELECT " . implode(',', $columns) . " FROM $table";
        
        $conditionSqlArr = $conditionData = [];
        foreach ($coditions as $field => $value) {
            $conditionSqlArr[] = "$field=:$field";
            $conditionData[":$field"] = $value ;
        }
        
        $orderSql = '';
        if(!empty($orderBy)) {
            $orderSql = ' ORDER BY '.$orderBy;
        }
        
        $conditionSql = '';
        if(!empty($conditionSqlArr)) {
            $conditionSql = ' WHERE '. implode(' AND ', $conditionSqlArr); // Support only AND condition of query
        }
        
        $finalSql = $sql.$conditionSql.$orderSql;
        //echo $finalSql;exit;
        $stmt = $this->conn->prepare($finalSql);
        $stmt->execute($conditionData);
        return $stmt->fetchAll();
    }
    
    /* Pagination related common functions */
    public function saveTotalRecordCount() {
        $sqlCount = 'SELECT FOUND_ROWS() AS total_records_count';
        $stmtCount = $this->conn->query($sqlCount);
        $recordCount = $stmtCount->fetch();
	
	//App::pre($recordCount);
	
        self::$TOTAL_RECORD_COUNT = $recordCount['total_records_count'];
    }
    
    public static function totalRecordCount() {
        return self::$TOTAL_RECORD_COUNT;
    }
    
    public static function getPageLimitQuery() {
        return ' LIMIT '.((Pagination::currentPage() - 1) * RECORDS_PER_PAGE).', '.RECORDS_PER_PAGE.' ';
    }
    /* End Pagination related common functions */

    public function saveEmailData(PHPMailer $emailData) {
        $sql = 'INSERT INTO support_tickets_emails (from_name, from_email, to_data, cc_emails, subject, body) VALUES (:from_name, :from_email, :to_data, :cc_emails, :subject, :body)';
        $stmt = $this->conn->prepare($sql);
        
        $sqlData = array(
            ':from_name' => $emailData->FromName,
            ':from_email' => $emailData->From,
            ':to_data' => json_encode($emailData->getToAddresses()),
            ':cc_emails' => json_encode($emailData->getCcAddresses()),
            ':subject' => $emailData->Subject,
            ':body' => $emailData->Body
        );
        return $stmt->execute($sqlData);
    }
}
