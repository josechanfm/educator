<template>
    <div>
      <a-menu
        v-model:openKeys="openKeys"
        v-model:selectedKeys="selectedKeys"
        mode="inline"
        theme="dark"
        :inline-collapsed="collapsed"
      >
        <template v-for="item in list" :key="item.key">
          <template v-if="!item.children">
            <a-menu-item :key="item.key">
              <template #icon>
                <PieChartOutlined />
              </template>
              {{ item.title }}
            </a-menu-item>
          </template>
          <template v-else>
            <sub-menu :key="item.key" :menu-info="item" />
          </template>
        </template>
      </a-menu>
    </div>
  </template>
  <script>
  import { defineComponent, ref } from 'vue';
  import { MenuFoldOutlined, MenuUnfoldOutlined, PieChartOutlined, MailOutlined } from '@ant-design/icons-vue'; // you can rewrite it to a single file component, if not, you should config vue alias to vue/dist/vue.esm-bundler.js
  
  const SubMenu = {
    name: 'SubMenu',
    props: {
      menuInfo: {
        type: Object,
        default: () => ({}),
      },
    },
    template: `
      <a-sub-menu :key="menuInfo.key">
        <template #icon><MailOutlined /></template>
        <template #title>{{ menuInfo.title }}</template>
        <template v-for="item in menuInfo.children" :key="item.key">
          <template v-if="!item.children">
            <a-menu-item :key="item.key">
              <template #icon>
                <PieChartOutlined />
              </template>
                <a :href="item.url">
                  {{ item.title }}
                </a>
            </a-menu-item>
          </template>
          <template v-else>
            <sub-menu :menu-info="item" :key="item.key" />
          </template>
        </template>
      </a-sub-menu>
    `,
    components: {
      PieChartOutlined,
      MailOutlined,
    },
  };
  const list = [{
    key: '1',
    title: '學校管理',
    children: [{
      key: '1.1',
      title: '課程規劃',
      url:'/admin/courses',
    },{
      key: '1.2',
      title: '教師資料',
      url:'/admin/teachers',
    },{
      key: '1.3',
      title: '教室資料',
      url:'/admin/rooms',
    }],
  },{
    key: '2',
    title: '課程管理',
    children: [{
      key: '2.1',
      title: '課程開設',
      url:'/admin/offers',
    },{
      key: '2.2',
      title: '分配教室',
      url:'/admin/scheduler',
    }],
  },{
    key: '3',
    title: 'Navigation 3',
    children: [{
      key: '3.1',
      title: 'Navigation 3',
      children: [{
        key: '3.1.1',
        title: 'Option 3.1.1',
      }],
    }],
  }];
  export default defineComponent({
    components: {
      'sub-menu': SubMenu,
      MenuFoldOutlined,
      MenuUnfoldOutlined,
      PieChartOutlined,
    },
  
    setup() {
      const collapsed = ref(false);
  
      const toggleCollapsed = () => {
        collapsed.value = !collapsed.value;
      };
  
      return {
        list,
        collapsed,
        toggleCollapsed,
        selectedKeys: ref(['1']),
        openKeys: ref(['2']),
      };
    },
  
  });
  </script>