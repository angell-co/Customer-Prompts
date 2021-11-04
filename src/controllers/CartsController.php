<?php
/**
 * Customer Prompts plugin for Craft Commerce
 *
 * Prompt your customers to buy.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2021 Angell & Co
 */

namespace angellco\customerprompts\controllers;

use angellco\customerprompts\CustomerPrompts;
use craft\commerce\db\Table as CommerceTable;
use craft\db\Query;
use craft\helpers\Db;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Class CartsController
 *
 * @author    Angell & Co
 * @package   CustomerPrompts
 * @since     1.0.0
 */
class CartsController extends Controller
{

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = Controller::ALLOW_ANONYMOUS_LIVE;

    /**
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionInActiveCarts(): Response
    {
        $this->requireAcceptsJson();

        $sku = $this->request->getRequiredParam('sku');
        $currentCartNumber = $this->request->getParam('cartNumber');

        // TODO Allow this to be overridden with our own config value
        $edge = CustomerPrompts::$commerce->getCarts()->getActiveCartEdgeDuration();

        $query = (new Query())
            ->select(['li.id'])
            ->from([CommerceTable::LINEITEMS . ' li'])
            ->leftJoin(CommerceTable::ORDERS . ' o', '[[li.orderId]] = [[o.id]]')
            ->where(['[[o.isCompleted]]' => false])
            ->andWhere('[[li.sku]] = :sku', [':sku' => $sku])
            ->andWhere(Db::parseDateParam('o.dateUpdated', $edge, '>='));

        if ($currentCartNumber) {
            $query->andWhere('[[o.number]] != :currentCartNumber', [':currentCartNumber' => $currentCartNumber]);
        }

        return $this->asJson([
            'success' => true,
            'activeCarts' => $query->count(),
        ]);
    }

}
