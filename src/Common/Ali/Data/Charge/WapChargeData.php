<?php
/**
 * @author: helei
 * @createTime: 2016-07-22 17:02
 * @description:
 */

namespace Payment\Common\Ali\Data\Charge;


use Payment\Common\AliConfig;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

class WapChargeData extends ChargeBaseData
{

    protected function checkDataParam()
    {
        parent::checkDataParam(); // TODO: Change the autogenerated stub

        // 手机网站支付接口  需要检查show_url 参数，必须上传
        $showUrl = $this->show_url;
        if (empty($showUrl)) {
            throw new PayException('使用手机网站支付接口时，必须提供show_url参数');
        }
    }

    /**
     * 构建 手机网站支付 加密数据
     * @author helei
     */
    protected function buildData()
    {
        $signData = [
            // 基本参数
            'service'   => 'alipay.wap.create.direct.pay.by.user',
            'partner'   => trim($this->partner),
            '_input_charset'   => trim($this->inputCharset),
            'sign_type'   => trim($this->signType),
            'notify_url'    => trim($this->notifyUrl),
            'return_url'    => trim($this->returnUrl),

            // 业务参数
            'out_trade_no'  => trim($this->order_no),
            'subject'   => trim($this->subject),
            'total_fee' => trim($this->amount),
            'seller_id' => trim($this->partner),
            'payment_type'  => 1,
            'show_url'  => trim($this->show_url),
            'body'  => trim($this->body),
            'it_b_pay'  => trim($this->timeExpire) . 'm',// 超时时间 统一使用分钟计算
            'goods_type'    => 1, //默认为实物类型
            //'app_pay'   => 'Y', // 是否使用支付宝客户端支付  如果为Y，需要处理alipays协议
        ];

        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }
}