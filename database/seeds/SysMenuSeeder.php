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
        $sys_first_menus = [
            [
                'name' => '首页',
                'url' => route('admin.index'),
            ],
            [
                'name' => '运营管理',
                'url' => route('admin.operation.index'),
            ],
            [
                'name' => '订单管理',
                'url' => route('admin.order.index'),
            ],
            [
                'name' => '店铺管理',
                'url' => route('admin.shop.index'),
            ],
            [
                'name' => '商品管理',
                'url' => route('admin.goods.index'),
            ],
        ];
        $sys_second_menus = [
            '首页' => [
                [
                    'name' => '系统管理',
                    'url' => '',
                ],
                [
                    'name' => '基础设置',
                    'url' => '',
                ],
                [
                    'name' => '会员管理',
                    'url' => '',
                ],
                [
                    'name' => '文章管理',
                    'url' => '',
                ],
            ],
            '运营管理' => [
                [
                    'name' => '推荐管理',
                    'url' => '',
                ],
                [
                    'name' => '财务管理',
                    'url' => '',
                ],
            ],
            '订单管理' => [
                [
                    'name' => '订单管理',
                    'url' => '',
                ],
                [
                    'name' => '投诉订单',
                    'url' => '',
                ],
                [
                    'name' => '退款订单',
                    'url' => '',
                ],
            ],
            '店铺管理' => [
                [
                    'name' => '店铺认证',
                    'url' => '',
                ],
                [
                    'name' => '开店申请',
                    'url' => '',
                ],
                [
                    'name' => '店铺管理',
                    'url' => '',
                ],
                [
                    'name' => '停用店铺',
                    'url' => '',
                ],
            ],
            '商品管理' => [
                [
                    'name' => '已上架商品',
                    'url' => '',
                ],
                [
                    'name' => '待审核商品',
                    'url' => '',
                ],
                [
                    'name' => '违规商品',
                    'url' => '',
                ],
                [
                    'name' => '商品分类',
                    'url' => '',
                ],
                [
                    'name' => '商品属性',
                    'url' => '',
                ],
                [
                    'name' => '品牌管理',
                    'url' => '',
                ],
                [
                    'name' => '商品规格',
                    'url' => '',
                ],
                [
                    'name' => '评价管理',
                    'url' => '',
                ],
            ],
        ];
        $sys_third_menus = [
            '系统管理' => [
                [
                    'name' => '管理员管理',
                    'url' => route('admin.system.staff.index'),
                ],
                [
                    'name' => '角色管理',
                    'url' => route('admin.system.role.index'),
                ],
                [
                    'name' => '登录日志',
                    'url' => route('admin.system.log.index'),
                ],
                [
                    'name' => '消息管理',
                    'url' => '',
                ],
            ],
            '基础设置' => [
                [
                    'name' => '平台配置',
                    'url' => '',
                ],
                [
                    'name' => '导航管理',
                    'url' => '',
                ],
                [
                    'name' => '广告管理',
                    'url' => '',
                ],
                [
                    'name' => '广告位置',
                    'url' => '',
                ],
                [
                    'name' => '银行管理',
                    'url' => '',
                ],
                [
                    'name' => '支付管理',
                    'url' => '',
                ],
                [
                    'name' => '地区管理',
                    'url' => '',
                ],
                [
                    'name' => '友情链接',
                    'url' => '',
                ],
                [
                    'name' => '快递管理',
                    'url' => '',
                ],
            ],
            '会员管理' => [
                [
                    'name' => '会员等级',
                    'url' => '',
                ],
                [
                    'name' => '会员管理',
                    'url' => '',
                ],
                [
                    'name' => '账号管理',
                    'url' => '',
                ],
            ],
            '文章管理' => [
                [
                    'name' => '文章管理',
                    'url' => '',
                ],
                [
                    'name' => '文章分类',
                    'url' => '',
                ],
            ],
        ];

        //创建一级菜单
        foreach ($sys_first_menus as $menu) {
            SysMenu::create([
                'parentId' => 0,
                'name' => $menu['name'],
                'url' => $menu['url'],
            ]);
        }

        //创建二级菜单
        foreach ($sys_second_menus as $key => $menus) {
            $parentId = SysMenu::where('name', $key)->where('parentId', 0)->value('id');
            if ($parentId > 0) {
                foreach ($menus as $menu) {
                    SysMenu::create([
                        'parentId' => $parentId,
                        'name' => $menu['name'],
                        'url' => $menu['url'],
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
                        'name' => $menu['name'],
                        'url' => $menu['url'],
                    ]);
                }
            }
        }
    }
}
