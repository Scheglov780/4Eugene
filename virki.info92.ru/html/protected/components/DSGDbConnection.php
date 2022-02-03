<?

class DSGDbConnection extends CDbConnection
{
    protected function open()
    {
        setlocale(LC_TIME, 'ru_RU.UTF8');
        try {
            parent::open();
            $this->createCommand("set lc_time to 'ru_RU.UTF8'")->execute();
//           $this->createCommand("set lc_collate to 'ru_RU.UTF8'")->execute();
//           $this->createCommand("set lc_ctype to 'ru_RU.UTF8'")->execute();
//           $this->createCommand("set LC_MONETARY to 'ru_RU'")->execute();
//           $this->createCommand("set LC_NUMERIC to 'ru_RU'")->execute();
        } catch (CDbException $e) {
            if ($_SERVER['REQUEST_URI'] != '/under') {
                Yii::app()->request->redirect('/under', true, 302);
            }
        }
    }

    /**
     * Creates a command for execution.
     * For quotation use:
     * [[column name]]: enclose a column name to be quoted in double square brackets;
     * {{table name}}: enclose a table name to be quoted in double curly brackets.
     * @param mixed $query the DB query to be executed. This can be either a string representing a SQL statement,
     *                     or an array representing different fragments of a SQL statement. Please refer to
     *                     {@link CDbCommand::__construct} for more details about how to pass an array as the query. If
     *                     this parameter is not given, you will have to call query builder methods of {@link
     *                     CDbCommand} to build the DB query.
     * @return CDbCommand the DB command
     */
    public function createCommand($query = null)
    {
        //@todo: здесь потом сделать квотирование reserved words для запросов. С привязкой к типу СУБД
        /*
         * https://www.postgresql.org/docs/13/sql-keywords-appendix.html
         *
         * */

        if (!is_array($query)) {
            $query = $this->quoteSql($query);
        }
        return parent::createCommand($query);
    }

    /**
     * Processes a SQL statement by quoting table and column names that are enclosed within double brackets.
     * Tokens enclosed within double curly brackets are treated as table names, while
     * tokens enclosed within double square brackets are column names. They will be quoted accordingly.
     * Also, the percentage character "%" at the beginning or ending of a table name will be replaced
     * with [[tablePrefix]].
     * @param string $sql the SQL to be quoted
     * @return string the quoted SQL
     */
    public function quoteSql($sql)
    {
        return preg_replace_callback(
          '/(\\{\\{(%?[\w\-\. ]+%?)\\}\\}|\\[\\[([\w\-\. ]+)\\]\\])/',
          function ($matches) {
              if (isset($matches[3])) {
                  return $this->quoteColumnName($matches[3]);
              }

              return str_replace('%', $this->tablePrefix, $this->quoteTableName($matches[2]));
          },
          $sql
        );
    }

}