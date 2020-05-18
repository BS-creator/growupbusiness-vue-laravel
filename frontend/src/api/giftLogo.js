import request from "@/utils/request";

export function store(logo) {
  return request({
    url: "/giftLogo",
    method: "post",
    data: logo
  });
}

export function get() {
  return request({
    url: "/giftLogo",
    method: "get"
  });
}

export function remove(logo) {
  return request({
    url: "/giftLogo/" + logo.id,
    method: "delete"
  });
}
