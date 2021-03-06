<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * @Route("/antbms", name="antbms_")
 */
class AntBmsController extends AbstractController
{
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }
    
    public function wrap($data)
    {
        $code = '';
        $message = '';
        $token  = '';
        $resp = [
            'Code' => $code,
            'Message' => $message,
            'Data' => $data,
            'Token' => $token
        ];
        return $resp;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        // return $this->json($resp);
        
        $resp = $this->redis->get('index');
        return new JsonResponse($resp, 200, [], true);
    }
    /**
     * @Route("/UserLogin", name="userlogin", methods={"POST"})
     */
    public function UserLogin(Request $request)
    {
        $data = $this->redis->hgetall('UserLogin');
        $username = $request->request->get('Username');
        $pass = $request->request->get('Pwd');
        $time = $request->request->get('Time');
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($username == 'admin' && $pass == '123456') {
            $response->headers->setCookie(Cookie::create('sessionid', 'sometoken'));
        }
        // return new JsonResponse($this->wrap($data));
        $response->setContent(json_encode($this->wrap($data)));
        $response->send();
    }

    /**
     * @Route("/GetUserEuipment", name="GetUserEuipment")
     */
    public function GetUserEuipment()
    {
        $data = $this->redis->hgetall('GetUserEuipment');
        return new JsonResponse($this->wrap($data));
    }

    /**
     * @Route("/GetEquipmentDetils", name="GetEquipmentDetils")
     */
    public function GetEquipmentDetils()
    {
        $data = $this->redis->hgetall('GetEquipmentDetils');
        return new JsonResponse($this->wrap($data));
    }

    /**
     * @Route("/GetSingleEquipment", name="GetSingleEquipment")
     */
    public function GetSingleEquipment()
    {
        $data = $this->redis->hgetall('GetSingleEquipment');
        return new JsonResponse($this->wrap($data));
    }

    /**
     * @Route("/init", name="init")
     */
    public function init()
    {
        $index = [
            'UserLogin' => '/UserLogin',
            'GetUserEuipment' => '/GetUserEuipment',
            'GetEquipmentDetils' => '/GetEquipmentDetils',
            'GetSingleEquipment' => '/GetSingleEquipment'
        ];
        $this->redis->del('index');
        $this->redis->set('index', json_encode($index, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $UserLogin = [
            // UserId—用户id、RoleId—用户角色id
            'UserId' => '',
            'RoleId' => ''
        ];
        $this->redis->del('UserLogin');
        foreach ($UserLogin as $k => $v) {
            $this->redis->hset('UserLogin', $k, $v);
        }

        $GetUserEuipment = [
            // EQUCODE—设备唯一码、EQUALIAS—设备别名、TCOUNT—数据总条数、TPAGE—数据总页数
            // EQUCUSTOMER—设备所属人id、EQUSTAUS—设备状态、LONGITUDE—经度、DIMENSION—维度
            // 其中EQUSTAUS 0表示未激活、4表示离线、8表示在线
            'EQUCODE' => '',
            'EQUALIAS' => '',
            'TCOUNT' => '',
            'TPAGE' => '',
            'EQUCUSTOMER' => '',
            'EQUSTAUS' => '',
            'LONGITUDE' => '',
            'DIMENSION' => '',
        ];
        $this->redis->del('GetUserEuipment');
        foreach ($GetUserEuipment as $k => $v) {
            $this->redis->hset('GetUserEuipment', $k, $v);
        }

        $GetEquipmentDetils = [
            // SBBH—设备唯一码、LONGITUDE—经度、DIMENSION—维度
            'SBBH' => '',
            'LONGITUDE' => '',
            'DIMENSION' => '',
        ];
        $this->redis->del('GetEquipmentDetils');
        foreach ($GetEquipmentDetils as $k => $v) {
            $this->redis->hset('GetEquipmentDetils', $k, $v);
        }

        $GetSingleEquipment = [
            // DcZt—电池状态 DwZt--定位状态 SjSj—数据时间 JdZb—经度坐标 WdZb—维度坐标 Zdy—总电压 Dl—电流 Soc—Soc
            // SyDl—剩余电量 ZxhRl—总循环容量 BmsYxSj—BMS运行时间 CdMosZt—充电MOS  状态 FdMosZt—放电MOS状态
            // JhZt—均衡状态 // JhZtZsw—均衡状态指示位 // Gl—功率 // ZgDtDy—最高单体电压 // ZgDtDyWz—最高单体电压位置
            // ZdDtDy—最低单体电压 ZdDtDyWz--最低单体电压位置 PjDtDy--平均单体电压 DcCs--电池串数 FdMosQdDy--放电MOS驱动电压
            // CdMosQdDy--充电MOS驱动电压 FdDnsDy--放电DS电压 DcCdCs--电池充电次数 DcGzZsw--电池故障指示位
            // DcGjZsw--电池告警指示位 DY1- DY32 设备单体电压32组 Wd1- Wd8设备温度 8组
            'DcZt' => '55.5',
            'DwZt' => '55.5',
            'SjSj' => '55.5',
            'JdZb' => '55.5',
            'WdZb' => '55.5',
            'Zdy' => '55.5',
            'Dl' => '55.5',
            'Soc' => '35.5',
            'SyDl' => '55.5',
            'ZxhRl' => '55.5',
            'BmsYxSj' => '55.5',
            'CdMosZt' => 1,
            'FdMosZt' => 0,
            'JhZt' => 1,
            'JhZtZsw' => '55.5',
            'Gl' => '55.5',
            'ZgDtDy' => '55.5',
            'ZgDtDyWz' => '55.5',
            'ZdDtDy' => '55.5',
            'ZdDtDyWz' => '55.5',
            'PjDtDy' => '55.5',
            'DcCs' => '55.5',
            'FdMosQdDy' => '55.5',
            'CdMosQdDy' => '55.5',
            'FdDnsDy' => '55.5',
            'DcCdCs' => '55.5',
            'DcGzZsw' => '55.5',
            'DcGjZsw' => '55.5',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $GetSingleEquipment['DY' . $i] = 55.5;
        }
        for ($i = 1; $i <= 4; $i++) {
            $GetSingleEquipment['Wd' . $i] = 55.5;
        }

        $this->redis->del('GetSingleEquipment');
        foreach ($GetSingleEquipment as $k => $v) {
            $this->redis->hset('GetSingleEquipment', $k, $v);
        }

        return $this->json('ok');
    }
}
