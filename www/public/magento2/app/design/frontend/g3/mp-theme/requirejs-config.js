var config = {
    map: {
        '*': {
            //"menu": "js/mage/menu-custom",
            'Magento_Catalog/js/product/breadcrumbs': 'js/breadcrumbs',
            'Amasty_ShopbyBase/js/chosen/chosen.jquery': 'js/chosen.jquery'
        }
    },
    deps: [
        'js/main.min',
    ],
    paths: {
        'swiper': 'js/swiper.min',
        //'swiperInit': 'js/swiper.init',
        'waypoints': 'js/waypoints.min'
    },
    shim: {
        "swiper":{
            'deps':['jquery']
        },
        //"swiperInit":{
        //    'deps':['jquery', 'swiper']
        //},
        "waypoints":{
            'deps':['jquery']
        }
    },
    config: {
        mixins: {
            'mage/collapsible': {
                'js/mage/collapsible-mixin': true
            }
        }
    }
};