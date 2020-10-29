<?php


namespace app\api\controller;


use think\Controller;
use think\Loader;
use think\Log;

class Trsource extends Controller
{

    public function getInfo()
    {
        $url = trim($this->request->param('url'));

        $httpReferer = pathinfo($url)['dirname'];

        $rootDir = './House/' . date('Ym') . '/';//存放目录
        $dir_ = iconv("UTF-8", "GBK", $rootDir);
        $this->checkDirectory($dir_);

        $filePath = './House/' . date('Ym') . '/' . md5($url);
        if (file_exists($filePath)) {
            $info = unserialize(file_get_contents($filePath));
        } else {
            $data = $this->getCurl($url, $httpReferer);

            if ($data['httpCode'] != 200) {
                    $res['code'] = 0;
                    $res['msg'] = '读取失败';
                    return json($res);
            }
            list($data['header'], $data['body']) = explode("\r\n\r\n", $data['body'], 2);
            $info = $this->getPreg($httpReferer, $data['body']);
            file_put_contents($filePath, serialize($info));
        }


        $data = $info;
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $data;
        return json($res);
    }

    /**
     * 检查目录是否存在，如不存在则创建
     */
    public function checkDirectory($dir_)
    {
        if (!is_dir($dir_)) {
            mkdir($dir_, 0777, true);
        }
    }

    // curl
    public function getCurl($url, $httpReferer, $options = [])
    {
        $ip = self::randIp();
        $curl = curl_init();
        $defaultOptions = [
            CURLOPT_URL => $url,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_REFERER => $httpReferer,
            CURLOPT_ENCODING => "gzip, deflate, sdch",
            CURLOPT_USERAGENT => '',
            CURLOPT_HTTPHEADER => [
                "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language:zh-CN,en-US;q=0.7,en;q=0.3",
                "HTTP_X_FORWARDED_FOR:{$ip}",
                "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36",
                "CLIENT-IP:{$ip}"]
        ];
        if ($options) {
            $defaultOptions = $options + $defaultOptions;
        }

        curl_setopt_array($curl, $defaultOptions);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $filePath = './uploads/cookie/' . md5($httpReferer);
        if (file_exists($filePath)) {
            $cookie = file_get_contents($filePath);
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }

        $data['body'] = curl_exec($curl);
        $data['httpCode'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $data;
    }

    /**
     *  随机ip
     */
    public static function randIp()
    {
        $ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 9);
        $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        return $ip;
    }

    public function getPreg($web, $body)
    {
        switch ($web) {
            case 'https://www.domain.com.au':
                $pattern = "/window\['__domain_group\/APP_PROPS'\] = (.*?); window\['__domain_group\/APP_PAGE'/";
                preg_match($pattern, $body, $match);
                $json_ = json_decode($match[1], true);
                $info['image'] = isset($json_['gallery']['slides'][0]['thumbnail']) ? $json_['gallery']['slides'][0]['thumbnail'] : '';

                $data['agents'] = $json_['agents'][0];
                $data['listingSummary'] = $json_['listingSummary'];
                foreach ($data['listingSummary']['stats'] as $val) {
                    $data['listingSummary'][$val['key']] = $val['value'];
                }
                $info['address'] = $data['listingSummary']['address'];
                $info['rent'] = $data['listingSummary']['price'];
                $info['house_room'] = $data['listingSummary']['beds'];
                $info['toilet'] = $data['listingSummary']['baths'];
                $info['car'] = $data['listingSummary']['parking'];
                $info['house_type'] = $data['listingSummary']['propertyType'];
                $info['live_date'] = isset($data['listingSummary']['availableFrom']) ? $data['listingSummary']['availableFrom'] : '';
                $info['bond'] = isset($data['listingSummary']['bond']) ? $data['listingSummary']['bond'] : '';
                $info['agency'] = $json_['agencyName'];
                $info['agent'] = $data['agents']['name'];
                $info['email'] = $data['agents']['email'];
                return $info;
                break;
            case 'https://www.realestate.com.au':
                $patternArr['address'] = '/fullAddress"\:"(.*?)"/';
                $patternArr['rent'] = '/"display":"(.*?)","__typename":"RentPrice"/';
                $patternArr['house_room'] = '/\\\"bedrooms\\\"\:(.*?),/';
                $patternArr['toilet'] = '/\\\"bathrooms\\\":(.*?),/';
                $patternArr['car'] = '/\\\"car_spaces\\\"\:(.*?),/';
                $patternArr['house_type'] = '/\\\"property_type\\\"\:\\\"(.*?)\\\"/';
                $patternArr['live_date'] = '/availableDate":{"display":"(.*?)","__typename":"AvailableDate"/';
                $patternArr['bond'] = '/bond":{"display":"(.*?)","__typename":"Bond"/';
                $patternArr['agent'] = '/{"name".*{"name":"(.*?)","photo"/';
                $info = [];
                foreach ($patternArr as $k => $pattern) {
                    preg_match($pattern, $body, $result);
                    $info[$k] = $result[1];
                }
                $patternHref = '/applyOnline":{"href":"(.*?)","__typename":"AbsoluteLinks/';
                preg_match($patternHref, $body, $resultHref);
                parse_str($resultHref[0], $resultHref);
                $info['email'] = $resultHref['papf_realestatem'];
                return $info;
                break;
            default:
                return false;
        }

    }


}