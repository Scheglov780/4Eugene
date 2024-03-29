<?php

class ControllerCode extends CCodeModel
{
    public $actions = 'index';
    public $baseClass = 'Controller';
    public $controller;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
          'baseClass'  => 'Base Class',
          'controller' => 'Controller ID',
          'actions'    => 'Action IDs',
        ]);
    }

    public function getActionIDs()
    {
        $actions = preg_split('/[\s,]+/', $this->actions, -1, PREG_SPLIT_NO_EMPTY);
        $actions = array_unique($actions);
        sort($actions);
        return $actions;
    }

    public function getControllerClass()
    {
        if (($pos = strrpos($this->controller, '/')) !== false) {
            return ucfirst(substr($this->controller, $pos + 1)) . 'Controller';
        } else {
            return ucfirst($this->controller) . 'Controller';
        }
    }

    public function getControllerFile()
    {
        $module = $this->getModule();
        $id = $this->getControllerID();
        if (($pos = strrpos($id, '/')) !== false) {
            $id[$pos + 1] = strtoupper($id[$pos + 1]);
        } else {
            $id[0] = strtoupper($id[0]);
        }
        return $module->getControllerPath() . '/' . $id . 'Controller.php';
    }

    public function getControllerID()
    {
        if ($this->getModule() !== Yii::app()) {
            $id = substr($this->controller, strpos($this->controller, '/') + 1);
        } else {
            $id = $this->controller;
        }
        if (($pos = strrpos($id, '/')) !== false) {
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        } else {
            $id[0] = strtolower($id[0]);
        }
        return $id;
    }

    public function getModule()
    {
        if (($pos = strpos($this->controller, '/')) !== false) {
            $id = substr($this->controller, 0, $pos);
            if (($module = Yii::app()->getModule($id)) !== null) {
                return $module;
            }
        }
        return Yii::app();
    }

    public function getUniqueControllerID()
    {
        $id = $this->controller;
        if (($pos = strrpos($id, '/')) !== false) {
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        } else {
            $id[0] = strtolower($id[0]);
        }
        return $id;
    }

    public function getViewFile($action)
    {
        $module = $this->getModule();
        return $module->getViewPath() . '/' . $this->getControllerID() . '/' . $action . '.php';
    }

    public function prepare()
    {
        $this->files = [];
        $templatePath = $this->templatePath;

        $this->files[] = new CCodeFile(
          $this->controllerFile,
          $this->render($templatePath . '/controller.php')
        );

        foreach ($this->getActionIDs() as $action) {
            $this->files[] = new CCodeFile(
              $this->getViewFile($action),
              $this->render($templatePath . '/view.php', ['action' => $action])
            );
        }
    }

    public function requiredTemplates()
    {
        return [
          'controller.php',
          'view.php',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
          ['controller, actions, baseClass', 'filter', 'filter' => 'trim'],
          ['controller, baseClass', 'required'],
          [
            'controller',
            'match',
            'pattern' => '/^\w+[\w+\\/]*$/',
            'message' => '{attribute} should only contain word characters and slashes.',
          ],
          [
            'actions',
            'match',
            'pattern' => '/^\w+[\w\s,]*$/',
            'message' => '{attribute} should only contain word characters, spaces and commas.',
          ],
          [
            'baseClass',
            'match',
            'pattern' => '/^[a-zA-Z_\\\\][\w\\\\]*$/',
            'message' => '{attribute} should only contain word characters and backslashes.',
          ],
          ['baseClass', 'validateReservedWord', 'skipOnError' => true],
          ['baseClass, actions', 'sticky'],
        ]);
    }

    public function successMessage()
    {
        $link = CHtml::link('try it now', Yii::app()->createUrl($this->controller), ['target' => '_blank']);
        return "The controller has been generated successfully. You may $link.";
    }
}