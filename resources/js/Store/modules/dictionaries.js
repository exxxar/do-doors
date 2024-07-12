import util from './utilites';

const state = {
    dictionary: {
        statuses: [
            {
                title: 'Новый клиент',
                value: 'new_client'
            },
            {
                title: 'Юридическое лицо',
                value: 'legal_entity'
            },
            {
                title: 'Физическое лицо',
                value: 'individual'
            },
            {
                title: 'Индивидуальный предприниматель',
                value: 'sole_proprietor'
            },
            {
                title: 'Дилер',
                value: 'dealer'
            },
            {
                title: 'Дистрибьютор',
                value: 'distributor'
            }
        ],
        prices: [
            {
                id: 1,
                height: 2100,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 2,
                height: 2100,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 3,
                height: 2100,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },

            {
                id: 4,
                height: 2300,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 14920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 5,
                height: 2300,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 15920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 6,
                height: 2300,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 16920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },

            {
                id: 7,
                height: 2500,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 8,
                height: 2500,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 9,
                height: 2500,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },

            {
                id: 10,
                height: 2700,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 11,
                height: 2700,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 12,
                height: 2700,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },

            {
                id: 13,
                height: 2800,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 14,
                height: 2800,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 15,
                height: 2800,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },

            {
                id: 16,
                height: 3000,
                width: 800,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 17,
                height: 3000,
                width: 900,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
            {
                id: 18,
                height: 3000,
                width: 1000,
                materials: [
                    {
                        id: 1,
                        title: "Стекло крашенное",
                        price: 12920
                    },
                    {
                        id: 2,
                        title: "Зеркало",
                        price: 8740
                    },
                    {
                        id: 3,
                        title: "Стекло цветное",
                        price: 8740
                    },
                    {
                        id: 4,
                        title: "Шпон",
                        price: 8740
                    },
                    {
                        id: 5,
                        title: "Мультишпон",
                        price: 9040
                    },
                    {
                        id: 6,
                        title: "Натуральный шпон",
                        price: 23504
                    },
                    {
                        id: 7,
                        title: "Натуральный шпон",
                        price: 6600
                    },
                    {
                        id: 8,
                        title: "Стекло",
                        price: 6600
                    },
                ]
            },
        ],
        purpose_variants: [
            'Входная', 'В спальню', 'В детскую', 'Офисная', 'В санузел'
        ],
        services:[],
        opening_variants: [
            {
                id: 1,
                title: 'НА СЕБЯ',
                depth: 45,
                direction: 'on',
                price: 0,
            },
            {
                id: 2,
                title: 'НА СЕБЯ',
                depth: 57,
                direction: 'on',
                price: 0,
            },
            {
                id: 3,
                title: 'ОТ СЕБЯ',
                depth: 57,
                direction: 'from',
                price: 0,
            }
        ],
        door_variants: [
            {
                id: 1,
                title: 'Комплект двери скрытого монтажа',
                price: 1000,
            },
            {
                id: 2,
                title: 'Короб',
                price: 2000,
            },
            {
                id: 3,
                title: 'Дверь Magic',
                price: 3000,
            },
            {
                id: 4,
                title: 'Полотно',
                price: 4000,
            }
        ],
        finishes_variants: [
            {
                id: 1,
                title: 'под покраску',
            },
            {
                id: 2,
                title: 'шпон',
                wrapper_variants: [
                    {
                        id: 1,
                        path: '/images/шпон/3 Albero 372S.png'
                    },
                    {
                        id: 2,
                        path: '/images/шпон/5 Bianche notti Crossing grey C.png'
                    },
                    {
                        id: 3,
                        path: '/images/шпон/7 Bianche notti 7064S.png'
                    },
                ],
                door_variants: [
                    {
                        id: 1,
                        path: '/images/шпон/4 Albero 372S.png'
                    },
                    {
                        id: 2,
                        path: '/images/шпон/6 Bianche notti Crossing grey C.png'
                    },
                    {
                        id: 3,
                        path: '/images/шпон/8 Bianche notti 7064S.png'
                    },
                    {
                        key: 'серебро',
                        path: '/images/зеркало/01 Silver.jpg'
                    },
                    {
                        key: 'серый',
                        path: '/images/зеркало/02 Gray.jpg'
                    },
                    {
                        key: 'бронза',
                        path: '/images/зеркало/03 Bronze.jpg'
                    }
                ]
            },
            {
                id: 3,
                title: 'зеркало',
                door_variants: [
                    {
                        key: 'серебро',
                        path: '/images/зеркало/01 Silver.jpg'
                    },
                    {
                        key: 'серый',
                        path: '/images/зеркало/02 Gray.jpg'
                    },
                    {
                        key: 'бронза',
                        path: '/images/зеркало/03 Bronze.jpg'
                    }
                ]
            },
            {
                id: 4,
                title: 'стекло прозрачное',

            },
            {
                id: 5,
                title: 'стекло крашеное по RAL',

            },
            {
                id: 6,
                title: 'эмаль',
                price: 6000,
            },
            {
                id: 7,
                title: 'панель Egger',

            },
        ], //варианты отделки
        loops_variants: [
            {
                id: 1,
                title: 'Слева',
                type: 'left'
            },
            {
                id: 2,
                title: 'Справа',
                type: 'right'
            },
        ], //петли
        size_variants: [
            {
                width: 800,
                height: 2100,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
                // loops_count:2,
            },
            {
                width: 1000,
                height: 2100,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 800,
                height: 2300,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 1000,
                height: 2300,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 800,
                height: 2500,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 1000,
                height: 2500,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 800,
                height: 2700,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 1000,
                height: 2700,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 800,
                height: 2800,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 1000,
                height: 2800,
                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 800,
                height: 3000,

                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
            {
                width: 1000,
                height: 3000,

                loops: [
                    {
                        material_id: 1,
                        loops_count: 3,
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }
                ],
            },
        ], //варианты размеров
        color_variants: [
            {
                id: 1,
                title: 'серебро',
                price: 0,
            },
            {
                id: 2,
                title: 'черный',
                price: 1000,
            },
            {
                id: 3,
                title: 'золотой',
                price: 2000,
            },
            {
                id: 4,
                title: 'RAL',
                price: 3000,
            },
        ], //варианты цветов
        handle_holes_variants: [
            {
                id: 1,
                title: 'Отверстие под ручку',
            },
            {
                id: 2,
                title: 'Отверстие под ручку и завертку',
            },
            {
                id: 3,
                title: 'Без отверстия под ручку',
            }
        ], //отверстие под ручку
        handle_holes_type_variants: [
            {
                id: 1,
                title: 'Ручка 1',
                price: 1000,
            },
            {
                id: 2,
                title: 'Ручка 2',
                price: 2000,
            },
            {
                id: 3,
                title: 'Ручка 3',
                price: 3000,
            }
        ], //отверстие под ручку
        hinge_manufacturer_variants: [
            {
                id: 1,
                title: 'Стандарт',
                price: 1000,
            },
            {
                id: 2,
                title: 'AGB',
                price: 2000,
            }
        ], //производитель петель
        price_type_variants: [
            {
                id: 1,
                title: 'Опт',
                key: 'wholesale'
            },
            {
                id: 2,
                title: 'Розница',
                key: 'dealer'
            },
            {
                id: 3,
                title: 'Цена дилера',
                key: 'retail'
            }
        ], //типы цен
    }
}

// getters
const getters = {

    getDictionary: (state, getters, rootState) => {
        return state.dictionary;
    },
}

// actions
const actions = {
    async loadFormattedSizes(context) {

        let link = `/sizes.json`
        let method = 'GET'


        let _axios = util.makeAxiosFactory(link, method)

        return _axios.then((response) => {
            context.commit("setDictionarySizes", response.data || [])
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
}

// mutations
const mutations = {
    setDictionarySizes(state, payload) {

        state.dictionary.prices = payload.prices || [];

        state.dictionary.size_variants = []

        payload.prices.forEach(item => {
            state.dictionary.size_variants.push({
                width: item.width,
                height: item.height,
                loops: item.loops || {
                    count: 0,
                    price: {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    }
                },
            })
        })

        state.dictionary.finishes_variants = []

        payload.materials.forEach(item => {

            state.dictionary.finishes_variants.push({
                id: item.id,
                title: item.title,
                is_base: item.is_base || false,
                wrapper_variants: item.wrapper_variants,
                door_variants: item.door_variants,
            })

        })

        state.dictionary.handle_holes_type_variants = []

        payload.handles.forEach(item => {
            state.dictionary.handle_holes_type_variants.push({
                id: item.id,
                title: item.title,
                price: item.price,
                color: item.color,
                variants: item.variants,
            })
        })

        state.dictionary.hinge_manufacturer_variants = []

        payload.hinges.forEach(item => {

            state.dictionary.hinge_manufacturer_variants.push({
                id: item.id,
                title: item.title,
                price: item.price,
            })
        })


        let directions = [
            {
                title: 'На себя',
                direction: 'on'
            },
            {
                title: 'От себя',
                direction: 'from'
            }
        ];

        state.dictionary.opening_variants = []

        directions.forEach(item => {
            Object.keys(payload.depth).forEach(key => {
                state.dictionary.opening_variants.push({
                    title: item.title,
                    direction: item.direction,
                    depth: key,
                    sizes: payload.depth[key]
                })
            })

        })

        state.dictionary.door_variants = []

        payload.door_variants.forEach(item => {
            state.dictionary.door_variants.push({
                id: item.id,
                title: item.title,
                need_percent_price: item.need_percent_price || false,
                price: item.price,
            })
        })


        state.dictionary.color_variants = []

        payload.colors.forEach(item => {
            state.dictionary.color_variants.push({
                id: item.id,
                title: item.title,
                assign_with_size: item.assign_with_size || false,
                sizes: item.sizes,
                code: item.code,
                type: item.type,
            })
        })

        state.dictionary.services = []

        payload.services.forEach(item => {
            state.dictionary.services.push(item)
        })
    },
}


const dictionaryModule = {
    state,
    mutations,
    actions,
    getters
}
export default dictionaryModule;
