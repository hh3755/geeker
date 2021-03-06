<?php
/**
 * @author: Jackong
 * Date: 14-3-4
 * Time: 下午1:24
 */

namespace src\service\taobao\handler;


use src\common\Log;
use src\service\Handler;

class Item extends Handler {

    private $minTradeNum = 0;

    public function minTradeNum($min) {
        $this->minTradeNum = $min;
        return $this;
    }

    public function handling($data) {
        $data = json_decode($data, true);
        if (is_null($data) || !isset($data['status']) || !isset($data['status']['code']) || $data['status']['code'] != 200) {
            Log::error('Items not found');
            return array(
                'tmall' => array(),
                'taobao' => array(),
            );
        }
        if (isset($data['page'])) {
            $this->setPage($data['page']['totalPage'], $data['page']['currentPage']);
        }

        return array(
            'tmall' => $this->filter($data['mallItemList']),
            'taobao' => $this->filter($data['itemList'])
        );
    }

    private function filter($items) {
        $newItems = array();
        if (is_null($items)) {
            return $newItems;
        }
        foreach ($items as $item) {
            if ($this->minTradeNum > $item['tradeNum']) {
                continue;
            }

            $newItems[] = $item;
        }
        return $newItems;
    }
}

/*
  {
    "image": "http://img02.taobaocdn.com/bao/uploaded/i2/T1A6KSFu4cXXXXXXXX_!!0-item_pic.jpg",
    "tip": "金粉世家2014春季时尚女包新款大包单肩手提包韩版潮流女士包包邮",
    "title": "金粉世家2014春季时尚女包新款大包单肩手提包韩版潮流女士包包邮",
    "price": "298.00",
    "currentPrice": "199.00",
    "vipPrice": "",
    "unitPrice": null,
    "unit": null,
    "isVirtual": "0",
    "ship": "0.0",
    "tradeNum": "14536",
    "nick": "金粉世家箱包旗舰店",
    "sellerId": "733424290",
    "guarantee": "0",
    "itemId": "23374884730",
    "isLimitPromotion": "0",
    "loc": "广东广州",
    "storeLink": "http://store.taobao.com/shop/view_shop.htm?user_number_id=733424290&ssid=r11",
    "href": "http://detail.tmall.com/item.htm?id=23374884730&source=dou",
    "commend": "33682",
    "commendHref": "http://detail.tmall.com/item.htm?id=23374884730&source=dou&on_comment=1",
    "multipic": "1",
    "spm": "d11",
    "sellerSpm": "d21",
    "source": "doufu",
    "icon": {
      "all": [
        {
          "id": "tmall"
        },
        {
          "id": "credit"
        }
      ]
    },
    "sameItemInfo": null,
    "similar": null,
    "ratesum": "15",
    "ratesumImg": null,
    "goodRate": null,
    "dsrScore": "4.83"
  }
 */