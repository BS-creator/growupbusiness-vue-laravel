import request from "@/utils/request";

export function store(bgImg) {
  return request({
    url: "/giftBgImg",
    method: "post",
    data: bgImg
  });
}

export function get() {
  return request({
    url: "/giftBgImg",
    method: "get"
  });
}

export function remove(bgImg) {
  return request({
    url: "/giftBgImg/" + bgImg.id,
    method: "delete"
  });
}
