<?php
/**
 * Zend Framework
 * LICENSE
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 * @category   Zend
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Zend_Search_Lucene_Search_Weight */
require_once 'Zend/Search/Lucene/Search/Weight.php';

/**
 * @category   Zend
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Search_Lucene_Search_Weight_MultiTerm extends Zend_Search_Lucene_Search_Weight
{
    /**
     * Zend_Search_Lucene_Search_Weight_MultiTerm constructor
     * query - the query that this concerns.
     * reader - index reader
     * @param Zend_Search_Lucene_Search_Query $query
     * @param Zend_Search_Lucene_Interface    $reader
     */
    public function __construct(
      Zend_Search_Lucene_Search_Query $query,
      Zend_Search_Lucene_Interface $reader
    ) {
        $this->_query = $query;
        $this->_reader = $reader;
        $this->_weights = [];

        $signs = $query->getSigns();

        foreach ($query->getTerms() as $id => $term) {
            if ($signs === null || $signs[$id] === null || $signs[$id]) {
                require_once 'Zend/Search/Lucene/Search/Weight/Term.php';
                $this->_weights[$id] = new Zend_Search_Lucene_Search_Weight_Term($term, $query, $reader);
                $query->setWeight($id, $this->_weights[$id]);
            }
        }
    }

    /**
     * The query that this concerns.
     * @var Zend_Search_Lucene_Search_Query
     */
    private $_query;
    /**
     * IndexReader.
     * @var Zend_Search_Lucene_Interface
     */
    private $_reader;
    /**
     * Query terms weights
     * Array of Zend_Search_Lucene_Search_Weight_Term
     * @var array
     */
    private $_weights;

    /**
     * The weight for this query
     * Standard Weight::$_value is not used for boolean queries
     * @return float
     */
    public function getValue()
    {
        return $this->_query->getBoost();
    }

    /**
     * Assigns the query normalization factor to this.
     * @param float $queryNorm
     */
    public function normalize($queryNorm)
    {
        // incorporate boost
        $queryNorm *= $this->_query->getBoost();

        foreach ($this->_weights as $weight) {
            $weight->normalize($queryNorm);
        }
    }

    /**
     * The sum of squared weights of contained query clauses.
     * @return float
     */
    public function sumOfSquaredWeights()
    {
        $sum = 0;
        foreach ($this->_weights as $weight) {
            // sum sub weights
            $sum += $weight->sumOfSquaredWeights();
        }

        // boost each sub-weight
        $sum *= $this->_query->getBoost() * $this->_query->getBoost();

        // check for empty query (like '-something -another')
        if ($sum == 0) {
            $sum = 1.0;
        }
        return $sum;
    }
}


