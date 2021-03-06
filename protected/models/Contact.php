<?php

/**
 * This is the model class for table "contact_detail".
 *
 * The followings are the available columns in table 'contact_detail':
 * @property integer $Id
 * @property string $Name
 * @property string $Address
 * @property integer $Telephone
 * @property string $Email
 * @property string $Tpye
 * @property string $Image
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Address, Telephone, Email, Tpye, Image', 'required'),
			array('Telephone', 'numerical', 'integerOnly'=>true),
			array('Name, Address', 'length', 'max'=>100),
			array('Email', 'length', 'max'=>50),
			array('Tpye, Image', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Name, Address, Telephone, Email, Tpye, Image', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Name' => 'Name',
			'Address' => 'Address',
			'Telephone' => 'Telephone',
			'Email' => 'Email',
			'Tpye' => 'Tpye',
			'Image' => 'Image',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Telephone',$this->Telephone);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Tpye',$this->Tpye,true);
		$criteria->compare('Image',$this->Image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getContactList(){
		$conn = Yii::app()->db;
		//$sql = "SELECT * FROM contact_detail ";
		$sql = "SELECT cd.name,cd.address,cd.id,cd.tel,cd.image,cd.type,cd.email,t.type_detail type_name FROM contact_detail cd, type t WHERE cd.type= t.id";
		$cmd = $conn->createCommand($sql);
		$response  = '';
		try{
			$response = $cmd->queryAll();
		}catch(Exception $ex){
			$response = $ex;
		}
			foreach ($response as &$contact) {
			$contact['photo'] = $contact['image'];
		}

		return $response;
	}

	public function addContactList($contactdata){
		$conn = Yii::app()->db;

       $response  = array('STATUS'=>'failure');

		$sql = "INSERT INTO contact_detail(name, address, tel, email, type, image) VALUES (:name, :address, :tel, :email, :type, :image)";

		$cmd = $conn->createCommand($sql);

        $cmd->bindParam(":name",$contactdata["name"],PDO::PARAM_STR);
        $cmd->bindParam(":address",$contactdata["address"],PDO::PARAM_STR);
        $cmd->bindParam(":tel",$contactdata["tel"],PDO::PARAM_INT);
        $cmd->bindParam(":email",$contactdata["email"],PDO::PARAM_STR);
        $cmd->bindParam(":type",$contactdata["type"],PDO::PARAM_INT);
        $cmd->bindParam(":image",$contactdata["photo"],PDO::PARAM_STR);
// var_dump($contactdata);
// exit;
      
       try{
              if($cmd->execute()){
               	$response['STATUS'] = 'success';
               }else{
               	$response['STATUS'] = 'failure';
               }
            }catch(Exception $ex){
            	$response = $ex;
            }
           return $response;

	 }

	  public function getUpdateContact($post_data){
        
        $conn= Yii::app()->db;
        $response  = array('STATUS'=>'failure');
        $sql="UPDATE contact_detail SET type=:type,
        					    name= :name,
        					    address=:address,
        					    tel=:tel,
        					    email=:email,
        					    image=:image 
        					    WHERE id = :id";
        $cmd = $conn->createCommand($sql);
        $cmd->bindParam(":id",$post_data["id"],PDO::PARAM_INT);
        $cmd->bindParam(":type",$post_data["type"],PDO::PARAM_STR);
        $cmd->bindParam(":name",$post_data["name"],PDO::PARAM_STR);
        $cmd->bindParam(":address",$post_data["address"],PDO::PARAM_STR);
        $cmd->bindParam(":tel",$post_data["tel"],PDO::PARAM_INT);
        $cmd->bindParam(":email",$post_data["email"],PDO::PARAM_STR);
        $cmd->bindParam(":image",$post_data["photo"],PDO::PARAM_STR);
       // $cmd->execute();
        // exit;
        try{
              if($cmd->execute()){
               	$response['STATUS'] = 'success';
               }else{
               	$response['STATUS'] = 'failure';
               }
            }catch(Exception $ex){
            	$response = $ex;
            }
            return $response;

	 }


	 public function deleteContact($post_data){
   
  		$conn = yii::app()->db;
	 	 $response  = array('STATUS'=>'failure');

	 	$sql="DELETE FROM contact_detail WHERE id = :id";

	 	 $cmd = $conn->createCommand($sql);

	 	$cmd->bindParam(":id",$post_data["id"],PDO::PARAM_INT);
        
        $cmd->execute();
        // try{
        //       if($cmd->execute()){
        //        	$response['STATUS'] = 'success';
        //        }else{
        //        	$response['STATUS'] = 'failure';
        //        }
        //     }catch(Exception $ex){
        //     	$response = $ex;
        //     }
            return $response;
	 }

	
}
