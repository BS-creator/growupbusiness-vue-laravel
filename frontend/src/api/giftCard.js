import request from "@/utils/request";

export function store(logo) {
  return request({
    url: "/giftCard",
    method: "post",
    data: logo
  });
}

export function get() {
  return request({
    url: "/giftCard",
    method: "get"
  });
}

export function update(cardId) {
  return request({
    url: "/giftCard/" + cardId,
    method: "PUT"
  });
}

export function getOne(cardId) {
  return request({
    url: "/giftCard/" + cardId,
    method: "get"
  });
}

export function remove(logo) {
  return request({
    url: "/giftCard/" + logo.id,
    method: "delete"
  });
}
