<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    // The nacos host info
    'host' => '127.0.0.1',
    'port' => 8848,

    // 服务注册，新服务会自动创建后再注册实例
    'service' => [
        'enable' => true, // 是否启用服务注册
        'namespace_id' => 'namespace_id', // 命名空间ID
        'group_name' => 'group_name', // 服务组
        'service_name' => 'payment.service.xxx.com', // 服务名
        'protect_threshold' => 0.5, // 服务保护阈值
        'cluster' => 'DEFAULT', // 实例所处虚拟集群
        'weight' => 80, // 实例权重
        'ephemeral' => true, // 是否临时实例
        'beat_enable' => true, // 是否发送实例心跳
        'beat_interval' => 5, // 心跳周期

        'remove_node_when_server_shutdown' => true, // 关机是否注销实例
        'load_balancer' => 'random', // 这个考虑放入服务发现模块
    ],

    // 配置中心
    'config' => [
        'enable' => true,
        'reload_interval' => 3,
        'listener_config' => [
            [
                'tenant' => 'namespace_id', // corresponding with service.namespaceId
                'group' => 'DEFAULT_GROUP',
                'data_id' => 'hyperf-service-config',
                'mapping_path' => 'xxx.yyy', // 为空则使用data_id作为配置路径，config('hyperf-service-config')
            ],
            [
                'tenant' => 'namespace_id', // corresponding with service.namespaceId
                'group' => 'DEFAULT_GROUP',
                'data_id' => 'hyperf-service-config-yml',
                'type' => 'yml',
            ]
        ]
    ]
];
