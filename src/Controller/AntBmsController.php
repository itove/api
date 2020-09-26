<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $resp = [
            'UserLogin' => '/UserLogin',
            'GetUserEuipment' => '/GetUserEuipment',
            'GetEquipmentDetils' => '/GetEquipmentDetils',
            'GetSingleEquipment' => '/GetSingleEquipment'
        ];
        // $this->redis->set('fuck', $resp);
        $resp = $this->redis->mget('fuck');
        // return $this->json($resp);
        // return new JsonResponse($resp);
        return new JsonResponse(json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), 200, [], true);
    }
    /**
     * @Route("/UserLogin", name="userlogin")
     */
    public function userLogin()
    {
        $resp = [
            'Code' => '',
            'Message' => '',
            'Data' => [ // UserId—用户id、RoleId—用户角色id
                'UserId' => '',
                'RoleId' => ''
            ],
            'Token' => ''
        ];
        return new JsonResponse($resp);
    }

    /**
     * @Route("/GetUserEuipment", name="GetUserEuipment")
     */
    public function getUserEuipment()
    {
        $resp = [
            'Code' => '',
            'Message' => '',
            'Data' => [
                // EQUCODE—设备唯一码、EQUALIAS—设备别名、TCOUNT—数据总条数、TPAGE—数据总页数
                // EQUCUSTOMER—设备所属人id、EQUSTAUS—设备状态、LONGITUDE—经度、DIMENSION—维度。其中EQUSTAUS 0表示未激活、4表示离线、8表示在线
                'EQUCODE' => '',
                'EQUALIAS' => '',
                'TCOUNT' => '',
                'TPAGE' => '',
                'EQUCUSTOMER' => '',
                'EQUSTAUS' => '',
                'LONGITUDE' => '',
                'DIMENSION' => '',
                '' => '',
                '' => '',
            ],
            'Token' => ''
        ];
        return new JsonResponse($resp);
    }

    /**
     * @Route("/GetEquipmentDetils", name="GetEquipmentDetils")
     */
    public function GetEquipmentDetils()
    {
        $resp = [
            'Code' => '',
            'Message' => '',
            'Data' => [ // SBBH—设备唯一码、LONGITUDE—经度、DIMENSION—维度
                'SBBH' => '',
                'LONGITUDE' => '',
                'DIMENSION' => '',
            ],
            'Token' => ''
        ];
        return new JsonResponse($resp);
    }

    /**
     * @Route("/GetSingleEquipment", name="GetSingleEquipment")
     */
    public function GetSingleEquipment()
    {
        $resp = [
            'Code' => '',
            'Message' => '',
            'Data' => [
                // DcZt—电池状态 DwZt--定位状态 SjSj—数据时间 JdZb—经度坐标 WdZb—维度坐标 Zdy—总电压 Dl—电流 Soc—Soc
                // SyDl—剩余电量 ZxhRl—总循环容量 BmsYxSj—BMS运行时间 CdMosZt—充电MOS  状态 FdMosZt—放电MOS状态
                // JhZt—均衡状态 // JhZtZsw—均衡状态指示位 // Gl—功率 // ZgDtDy—最高单体电压 // ZgDtDyWz—最高单体电压位置
                // ZdDtDy—最低单体电压 ZdDtDyWz--最低单体电压位置 PjDtDy--平均单体电压 DcCs--电池串数 FdMosQdDy--放电MOS驱动电压
                // CdMosQdDy--充电MOS驱动电压 FdDnsDy--放电DS电压 DcCdCs--电池充电次数 DcGzZsw--电池故障指示位
                // DcGjZsw--电池告警指示位 DY1- DY32 设备单体电压32组 Wd1- Wd8设备温度 8组
                'DcZt' => '',
                'DwZt' => '',
                'SjSj' => '',
                'JdZb' => '',
                'WdZb' => '',
                'Zdy' => '',
                'Dl' => '',
                'Soc' => '',
                'SyDl' => '',
                'ZxhRl' => '',
                'BmsYxSj' => '',
                'CdMosZt' => '',
                'FdMosZt' => '',
                'JhZt' => '',
                'JhZtZsw' => '',
                'Gl' => '',
                'ZgDtDy' => '',
                'ZgDtDyWz' => '',
                'ZdDtDy' => '',
                'ZdDtDyWz' => '',
                'PjDtDy' => '',
                'DcCs' => '',
                'FdMosQdDy' => '',
                'CdMosQdDy' => '',
                'FdDnsDy' => '',
                'DcCdCs' => '',
                'DcGzZsw' => '',
                'DcGjZsw' => '',
            ],
            'Token' => ''
        ];
        return new JsonResponse($resp);
    }
}
