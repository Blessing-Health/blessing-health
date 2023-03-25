const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("src/pages/DashBoard.vue"),
      },
      {
        path: "users",
        component: () => import("src/pages/UsersPage.vue"),
      },
      ////////////////////////////////////////////////////////////
      // Role Managment//
      ////////////////////////////////////////////////////////////
      {
        path: "roles",
        name: "roles",
        component: () => import("src/pages/Roles.vue"),
      },
      {
        path: "create_roles",
        name: "create-roles",
        component: () => import("src/pages/RoleForm.vue"),
      },
      {
        path: "permissions",
        component: () => import("src/pages/Permissions.vue"),
      },
    ],
  },
  {
    path: "/auth",
    component: () => import("layouts/BlankLayout.vue"),
    children: [
      {
        path: "login",
        component: () => import("src/pages/LoginPage.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
