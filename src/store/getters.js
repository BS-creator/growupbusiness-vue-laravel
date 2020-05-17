const getters = {
  sidebar: state => state.app.sidebar,
  size: state => state.app.size,
  device: state => state.app.device,
  visitedViews: state => state.tagsView.visitedViews,
  cachedViews: state => state.tagsView.cachedViews,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  name: state => state.user.name,
  introduction: state => state.user.introduction,
  roles: state => state.user.roles,
  permission_routes: state => state.permission.routes,
  errorLogs: state => state.errorLog.logs,
  giftLogos: state => state.giftLogo.logoImgs,
  giftBgImgs: state => state.giftBgImg.bgImgs,
  giftCards: state => state.giftCard.giftCards,
  activeGiftCard: state => state.giftCard.activeCard
};
export default getters;
