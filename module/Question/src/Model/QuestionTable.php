<?php
namespace Question\Model;

use RuntimeException;
use Zend\Db\Sql\Sql;

use Zend\Db\TableGateway\TableGatewayInterface;


class QuestionTable{

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    //fetch All
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    //getTable
    public function getTableName(){
        return $this->tableGateway->getTable();
    }
    //select data when id = 2
    public function selectData()
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from('cau_hois');
        $select->where(['id'=> 2]);
        //Không có chuỗi truy vấn
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result;
    }
    //select demo 2
    public function select02()
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select();
        //truy vấn
        $select->from(['q' => 'cau_hois'])
        ->columns(['ma_cau_hoi' => 'id','content'=> 'noi_dung','answer'=>'dap_an'])
        ->join(['lv'=>'linh_vuc'],'q.id_linh_vuc = lv.id',['linh_vuc' => 'ten_linh_vuc'],$select::JOIN_LEFT)
        ->order('q.id DESC')->limit(10);

        //Có chuổi truy vẫn
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString,$adapter::QUERY_MODE_EXECUTE);
        return $results;


    }
    //getting names field for select element
    public function getField()
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from('linh_vuc')->columns(['id','ten_linh_vuc']);

        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString,$adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    //Lưu dữ liệu vào model
    public function saveQuestion(Question $question)
    {
        $data = [
           'id'=> $question->id,
           'noi_dung'=> $question->noi_dung,
           'id_linh_vuc'=> $question->id_linh_vuc,
           'phuong_an_A'=> $question->phuong_an_A,
           'phuong_an_B'=> $question->phuong_an_B,
           'phuong_an_C'=> $question->phuong_an_C,
           'phuong_an_D'=> $question->phuong_an_D,
           'dap_an'=> $question->dap_an,
           'trang_thai'=> $question->trang_thai,
           'deleted_at'=> $question->deleted_at,
           'created_at'=> $question->created_at,
           'updated_at'=> $question->updated_at,
        ];
        $this->tableGateway->insert($data);
       
    }

}

?>