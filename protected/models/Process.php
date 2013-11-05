<?php

/**
 * This is the model class for table "process".
 *
 * The followings are the available columns in table 'process':
 * @property integer $id
 * @property string $name
 * @property string $timestart
 * @property string $timeexec
 * @property integer $status
 * @property integer $iduser
 * @property integer $iduseredit
 */
class Process extends CActiveRecord {

    const RUN = 2;
    const STOP = 5;
    const DONE = 6;

    public static function getLabelStatus($status) {
        switch ($status) {
            case self::RUN: $result = 'Выполняется';
                break;
            case self::STOP: $result = 'Прерван';
                break;
            case self::DONE: $result = 'Выполнен';
                break;
            default : $result = NULL;
        }

        return $result;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'process';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, timeexec', 'required'),
            array('timeexec, status, iduser', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, timeexec, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'iduser')
        );
    }

    public static function getStateProcess($process) {
        
        if (!is_null($process)) {
            //var_dump(time(), $process->timestart, $process->timeexec);
            if ($process->status == self::RUN) {
                $state = ((time() - $process->timestart) / $process->timeexec) * 100;
            } elseif ($process->status == self::DONE) {
                $state = 100;
            } else {
                $state = 0;
            }
        }

        return (int) $state;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID процесса',
            'name' => 'Имя процесса',
            'timestart' => 'Время запуска процесса',
            'timeexec' => 'Время выполнения',
            'status' => 'Статус процесса',
            'iduser' => 'Id автора',
            'iduseredit' => 'ID последнего автора изменений',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        //$criteria->compare('timestart',$this->timestart,true);
        $criteria->compare('timeexec', $this->timeexec, true);
        $criteria->compare('status', $this->status);
        //$criteria->compare('iduser',$this->iduser);
//		$criteria->compare('iduseredit',$this->iduseredit);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Process the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
