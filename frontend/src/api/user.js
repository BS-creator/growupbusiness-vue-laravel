import request from "@/utils/request";

export function login(data) {
  return request({
    url: "/signin",
    method: "post",
    data
  });
}

export function signup(data) {
  return request({
    url: "/signup",
    method: "post",
    data
  });
}

export function socialSignup(data) {
  return request({
    url: "/socialsignup/" + data.provider,
    method: "post",
    data: data.response
  });
}

export function socialSignin(data) {
  return request({
    url: "/socialsignin/" + data.provider,
    method: "post",
    data: data.response
  });
}

export function getInfo(token) {
  return request({
    url: "/user_info",
    method: "get",
    params: { token }
  });
}

export function logout() {
  return request({
    url: "/logout",
    method: "post"
  });
}
