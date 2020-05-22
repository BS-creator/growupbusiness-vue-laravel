import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

/* Layout */
import Layout from "@/layout";

/* Router Modules */
import componentsRouter from "./modules/components";
import chartsRouter from "./modules/charts";
import tableRouter from "./modules/table";
import nestedRouter from "./modules/nested";
import initRouter from "./modules/init";

/**
 * Note: sub-menu only appear when route children.length >= 1
 * Detail see: https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 *
 * hidden: true                   if set true, item will not show in the sidebar(default is false)
 * alwaysShow: true               if set true, will always show the root menu
 *                                if not set alwaysShow, when item has more than one children route,
 *                                it will becomes nested mode, otherwise not show the root menu
 * redirect: noRedirect           if set noRedirect will no redirect in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * meta : {
    roles: ['admin','editor']    control the page roles (you can set multiple roles)
    title: 'title'               the name show in sidebar and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if set true, the page will no be cached(default is false)
    affix: true                  if set true, the tag will affix in the tags-view
    breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
    activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
  }
 */

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [
  {
    path: "/auth/:provider/callback",
    component: {
      template: '<div class="auth-component"></div>'
    }
  },
  {
    path: "/redirect",
    component: Layout,
    hidden: true,
    children: [
      {
        path: "/redirect/:path(.*)",
        component: () => import("@/views/redirect/index")
      }
    ]
  },
  {
    path: "/login",
    component: () => import("@/views/auth/signin/index"),
    hidden: true
  },
  {
    path: "/signup",
    component: () => import("@/views/auth/signup/index"),
    hidden: true
  },
  {
    path: "/auth-redirect",
    component: () => import("@/views/auth/signin/auth-redirect"),
    hidden: true
  },
  {
    path: "/404",
    component: () => import("@/views/error-page/404"),
    hidden: true
  },
  {
    path: "/401",
    component: () => import("@/views/error-page/401"),
    hidden: true
  },
  {
    path: "/",
    component: Layout,
    redirect: "/gift-card",
    children: [
      {
        path: "dashboard",
        component: () => import("@/views/dashboard/index"),
        name: "Dashboard",
        hidden: true,
        meta: {
          title: "Dashboard",
          icon: "dashboard",
          roles: ["admin"],
          affix: true
        }
      }
    ]
  },
  {
    path: "/instructions",
    component: Layout,
    redirect: "/instructions/index",
    children: [
      {
        path: "index",
        component: () => import("@/views/blank/index"),
        name: "Instructions",
        meta: {
          title: "Instruction",
          icon: "list",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  },
  {
    path: "/gift-card",
    component: Layout,
    redirect: "/gift-card/index",
    children: [
      {
        path: "index",
        component: () => import("@/views/giftcard/index"),
        name: "Gifts",
        meta: {
          title: "Gift Card",
          icon: "gift",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  },
  {
    path: "/gift-card/creator",
    component: () => import("@/views/giftcardcreator/index"),
    name: "GiftsCreator",
    hidden: true,
    meta: {
      roles: ["admin"],
      noCache: true
    }
  },
  {
    path: "/gift-card/editor",
    component: () => import("@/views/giftcardcreator/index"),
    name: "GiftsEditor",
    hidden: true,
    meta: {
      roles: ["admin"],
      noCache: true
    }
  },
  {
    path: "/projects",
    component: Layout,
    redirect: "/projects/index",
    children: [
      {
        path: "index",
        component: () => import("@/views/blank/index"),
        name: "Projects",
        meta: {
          title: "Projects",
          icon: "briefing",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  },
  {
    path: "/followed Users",
    component: Layout,
    redirect: "/followed Users/index",
    children: [
      {
        path: "index",
        component: () => import("@/views/blank/index"),
        name: "Followed Users",
        meta: {
          title: "Followed Users",
          icon: "group",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  },
  {
    path: "/myinvoices",
    component: Layout,
    redirect: "/myinvoices/index",
    children: [
      {
        path: "index",
        component: () => import("@/views/blank/index"),
        name: "Myinvoices",
        meta: {
          title: "My Invoices",
          icon: "invoice",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  },
  {
    path: "/profile",
    component: Layout,
    redirect: "/profile/index",
    hidden: true,
    children: [
      {
        path: "index",
        component: () => import("@/views/blank/index"),
        name: "Profile",
        meta: {
          title: "Profile",
          icon: "user",
          roles: ["admin"],
          noCache: true
        }
      }
    ]
  }
  // {
  //   path: "/guide",
  //   component: Layout,
  //   redirect: "/guide/index",
  //   children: [
  //     {
  //       path: "index",
  //       component: () => import("@/views/guide/index"),
  //       name: "Guide",
  //       meta: { title: "Guide", icon: "guide", roles: ["admin"], noCache: true }
  //     }
  //   ]
  // }
];

const createRouter = () =>
  new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes
  });

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
}

export default router;
