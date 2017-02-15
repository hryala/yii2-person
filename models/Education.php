<?php

namespace andahrm\person\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use andahrm\person\models\Nationality as Country;

/**
 * This is the model class for table "person_education".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $year_start
 * @property string $year_end
 * @property integer $level_id
 * @property string $degree
 * @property string $branch
 * @property string $institution
 * @property integer $country_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property Person $user
 * @property PersonEducationLevel $level
 */
class Education extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_education';
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year_start', 'year_end', 'level_id', 'degree', 'branch', 'institution', 'country_id'], 'required'],
            [['user_id', 'level_id', 'country_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['year_start', 'year_end'], 'safe'],
            [['degree', 'branch', 'institution', 'province'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationLevel::className(), 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/person', 'ID'),
            'user_id' => Yii::t('andahrm/person', 'User ID'),
            'year_start' => Yii::t('andahrm/person', 'Year Start'),
            'year_end' => Yii::t('andahrm/person', 'Year End'),
            'level_id' => Yii::t('andahrm/person', 'Level ID'),
            'degree' => Yii::t('andahrm/person', 'Degree'),
            'branch' => Yii::t('andahrm/person', 'Branch'),
            'institution' => Yii::t('andahrm/person', 'Institution'),
            'province' => Yii::t('andahrm/person', 'Province'),
            'country_id' => Yii::t('andahrm/person', 'Country ID'),
            'created_by' => Yii::t('andahrm/person', 'Created By'),
            'created_at' => Yii::t('andahrm/person', 'Created At'),
            'updated_by' => Yii::t('andahrm/person', 'Updated By'),
            'updated_at' => Yii::t('andahrm/person', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(EducationLevel::className(), ['id' => 'level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
