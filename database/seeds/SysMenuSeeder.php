<?php

use App\Models\SysMenu;
use Illuminate\Database\Seeder;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sys_first_menus = ['首页', '运营管理', '订单管理', '店铺管理', '商品管理'];
        $sys_second_menus = array(
            '首页' => array('系统管理', '基础设置', '会员管理', '文章管理'),
            '运营管理' => array('推荐管理', '财务管理'),
            '订单管理' => array('订单管理'),
            '店铺管理' => array('店铺管理'),
            '商品管理' => array('商品管理'),
        );
        $sys_third_menus = array(
            '系统管理' => array('菜单权限', '前台菜单', '角色管理', '职员管理', '登录日志', '操作日志', '消息管理'),
            '基础设置' => array('商城配置', '导航管理', '广告管理', '广告位置', '银行管理', '支付管理', '地区管理', '友情链接', '快递管理'),
            '会员管理' => array('会员等级', '会员管理', '账号管理'),
            '文章管理' => array('文章管理', '文章分类'),
            '推荐管理' => array('商品推荐', '店铺推荐', '品牌推荐'),
            '财务管理' => array('提现申请', '结算申请', '商家结算'),
            '订单管理' => array('订单管理', '投诉订单', '退款订单'),
            '店铺管理' => array('店铺认证', '开店申请', '店铺管理', '停用店铺'),
            '商品管理' => array('已上架商品', '待审核商品', '违规商品', '商品分类', '商品属性', '品牌管理', '商品规格', '评价管理'),
        );

        //创建一级菜单
        foreach ($sys_first_menus as $menu) {
            SysMenu::create([
                'parentId' => 0,
                'name' => $menu,
            ]);
        }

        //创建二级菜单
        foreach ($sys_second_menus as $key => $menus) {
            $parentId = SysMenu::where('name', $key)->where('parentId', 0)->value('id');
            if ($parentId > 0) {
                foreach ($menus as $menu) {
                    SysMenu::create([
                        'parentId' => $parentId,
                        'name' => $menu,
                    ]);
                }
            }
        }

        //创建三级菜单
        foreach ($sys_third_menus as $key => $menus) {
            $parentId = SysMenu::where('name', $key)->where('parentId', '>', 0)->value('id');
            if ($parentId > 0) {
                foreach ($menus as $menu) {
                    SysMenu::create([
                        'parentId' => $parentId,
                        'name' => $menu,
                    ]);
                }
            }
        }
    }
}
