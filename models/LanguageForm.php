<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LanguageForm is the model behind the language form.
 */
class LanguageForm extends Model
{
    public $locales = [
        "en-US" => "English",
        "es-PE" => "Español"
    ];
    public $selected;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['selected', 'required'],
            ['selected', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'selected' => Yii::t('app', 'Language')
        ];
    }
}