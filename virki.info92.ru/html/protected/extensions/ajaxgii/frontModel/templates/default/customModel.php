<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo '<?' ?>
/*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* =================================================================================================================
*
<description file="custom<?= $modelClass ?>.php">
  *
</description>
*******************************************************************************************************************/
<?php echo '?>' ?>

<?php echo "<?php\n"; ?>

/**
* This is the model class for table "<?php echo $tableName; ?>".
*
* The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach ($columns as $column): ?>
  * @property <?php echo $column->type . ' $' . $column->name . "\n"; ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
  *
  * The followings are the available model relations:
    <?php foreach ($relations as $name => $relation): ?>
    * @property <?php
        if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches)) {
            $relationType = $matches[1];
            $relationModel = $matches[2];

            switch ($relationType) {
                case 'HAS_ONE':
                    echo $relationModel . ' $' . $name . "\n";
                    break;
                case 'BELONGS_TO':
                    echo $relationModel . ' $' . $name . "\n";
                    break;
                case 'HAS_MANY':
                    echo $relationModel . '[] $' . $name . "\n";
                    break;
                case 'MANY_MANY':
                    echo $relationModel . '[] $' . $name . "\n";
                    break;
                default:
                    echo 'mixed $' . $name . "\n";
            }
        }
        ?>
    <?php endforeach; ?>
<?php endif; ?>
*/
class custom<?php echo $modelClass; ?> extends <?php echo $this->baseClass . "\n"; ?>
{

/**
* @return array customized attribute labels (name=>label)
*/
public function attributeLabels()
{
return array(
<?php foreach ($labels as $name => $label): ?>
    <?php echo "'" . $name . "' => Yii::t('main','" . str_replace("'", "\'", $label) . "'),\n"; ?>
<?php endforeach; ?>
);
}

public function getAttributes($names = true)
{
$attr = parent::getAttributes($names);
return $attr;
}

public static function getUpdateLink($id, $external = false, $model = null, $value = null)
{
if (!strlen($id)) {
return '<a href="#">&dash;</a>';
}
if (is_null($model)) {
$model = self::model()->findByPk($id);
}
if ($model) {
if (is_null($value)) {
$value = addslashes($model->name);
}
$tabName = addslashes($model->name);
if ($external) {
return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
'site_domain'
) . '/admin/main/open?url=admin/<?= '{$viewsPath}' ?>/view/id/' . $id . '&tabName=' . $tabName;
} else {
$url = Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/<?= '{$viewsPath}' ?>/view', array('id' => $id));
return '<a href="' . $url . '" title="' . Yii::t(
                        'admin',
                        'Просмотр профиля'
                      ) . '" onclick="getContent(this,\'' . $tabName . '\',false);return false;"><i
      class="fa fa-name"></i>&nbsp;' . $value . '</a>';
}
} else {
return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
}
}

public static function getModelSearchSnippet($id, $query)
{
if (!function_exists('markup')) {
function markup($val, $query)
{
$result = @preg_replace('/' . $query . '/i', '<strong>' . $query . '</strong>', $val);
if (isset($result) && $result) {
return $result;
} else {
return $val;
}
}
}
$model = self::model()->findByPk($id);
$res = '';
$fields = array(
'name',
'description',
'comments',
);
if ($model) {
foreach ($fields as $field) {
if (strlen($model->{$field}) > 0) {
$res = $res . '<small>' . $model->getAttributeLabel($field) . ':</small> ' . markup(
$model->{$field},
$query
) . '&nbsp;';
}
}
}
return $res;
}

/**
* Returns the static model of the specified AR class.
* @return DSActiveRecord|CActiveRecord the static model class
*/
public static function model($className = __CLASS__)
{
return parent::model(preg_replace('/^custom/', '', $className));
}

/**
* @return array relational rules.
*/
public function relations()
{
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
return array(
<?php foreach ($relations as $name => $relation): ?>
    <?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
);
}

/**
* @return array validation rules for model attributes.
*/
public function rules()
{
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
return array(
<?php foreach ($rules as $rule): ?>
    <?php echo $rule . ",\n"; ?>
<?php endforeach; ?>
// The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
);
}

/**
* @return string the associated database table name
*/
public function tableName()
{
return '<?php echo $tableName; ?>';
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
public function search($criteria = null, $pageSize = 100, $dataProviderId = null)
{
if (!$criteria) {
$criteria = new CDbCriteria;
}
if (!$dataProviderId) {
$dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()).'_dataProvider';
}
$criteria->select =
/** @lang PostgreSQL */
"t.*";
<?php
foreach ($columns as $name => $column) {
    if ($column->type === 'string') {
        echo "\t if (\$this->$name) {";
        echo "\t\t\$criteria->addSearchCondition('$name',\$this->$name,true,'AND', 'ILIKE');\n";
        echo "\t }";
    } else {
        echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
    }
}
?>

return new CActiveDataProvider($this, array(
'id' => $dataProviderId,
'criteria'=>$criteria,
'sort'       => array(
// Indicate what can be sorted
'attributes'   => array(
'name'            => array(
'asc'  => 'name ASC',
'desc' => 'name DESC',
),
'description' => array(
'asc'  => 'description ASC',
'desc' => 'description DESC',
),
),
'defaultOrder' => array(
'name' => CSort::SORT_ASC,
),
),
'pagination' => array(
'pageSize' => $pageSize,
)
));
}

<?php if ($connectionId != 'db'): ?>
  /**
  * @return CDbConnection the database connection used for this class
  */
  public function getDbConnection()
  {
  return Yii::app()-><?php echo $connectionId ?>;
  }

<?php endif ?>
}
