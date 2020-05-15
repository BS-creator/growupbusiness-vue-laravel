<template>
  <div class="app-container giftcreator-wrapper">
    <el-container>
      <el-header>
        <router-link to="/gift">
          <el-button :loading="loading" type="primary" class="login-btn" size="large">
            <div>
              <i class="fa fa-sign-plus"></i>
              <span>GO BACK</span>
            </div>
          </el-button>
        </router-link>
        <el-button
          :loading="loading"
          type="primary"
          class="login-btn"
          size="large"
          style="float: right"
        >
          <div>
            <i class="fa fa-sign-plus"></i>
            <span>SAVE CARD</span>
          </div>
        </el-button>
      </el-header>
    </el-container>
    <div class="giftcard-creator">
      <el-container></el-container>
      <el-container>
        <!-- SETTING BAR BEGIN -->
        <el-aside>
          <!-- SETTING BAR TAB BEGIN -->
          <el-tabs :tab-position="tabPosition">
            <!-- LOGO TAB BEGIN -->
            <el-tab-pane>
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">Logo</div>
                  <svg-icon icon-class="qq" />
                </el-tooltip>
              </div>
              <!-- LOGO SETTING BEGIN -->
              <div>
                <div class="tab-content-header">Logo Images</div>
                <div class="tab-setting-section">
                  <template>
                    <div class="block">
                      <span class="demonstration">Top:</span>
                      <el-slider :max="backgroundColor.height" v-model="logo.top"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="backgroundColor.width" v-model="logo.left"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Size:</span>
                      <el-slider :max="100" v-model="logo.width"></el-slider>
                    </div>
                    <!-- <div class="block">
                      <span class="demonstration">Height:</span>
                      <el-slider :max="backgroundColor.height" v-model="logo.height"></el-slider>
                    </div>-->
                  </template>
                  <div style="    margin-top: 17px;">
                    <el-switch
                      v-model="logo.enable"
                      active-text="Enabled"
                      inactive-text="Clear"
                      @change="onLogoSwitchChange()"
                    ></el-switch>
                  </div>
                </div>
                <el-scrollbar wrap-class="scrollbar-wrapper">
                  <div id="test">
                    <el-upload action="#" list-type="picture-card" :auto-upload="false">
                      <i slot="default" class="el-icon-plus"></i>
                      <div slot="file" slot-scope="{file}" style="height:100%">
                        <img
                          class="el-upload-list__item-thumbnail"
                          :src="file.url"
                          style="object-fit: cover;"
                          alt
                        />
                        <span class="el-upload-list__item-actions" @click="applyLogo(file)">
                          <span
                            class="el-upload-list__item-preview"
                            @click="handleLogoPreview(file)"
                          >
                            <i class="el-icon-zoom-in"></i>
                          </span>
                          <span class="el-upload-list__item-delete" @click="handleLogoRemove(file)">
                            <i class="el-icon-delete"></i>
                          </span>
                        </span>
                      </div>
                    </el-upload>
                    <el-dialog :visible.sync="logoDialogVisible">
                      <img width="100%" :src="logoDialogImageUrl" alt />
                    </el-dialog>
                  </div>
                </el-scrollbar>
              </div>
              <!-- LOGO SETTING END -->
            </el-tab-pane>
            <!-- LOGO TAB END -->

            <!-- BACKGROUND IMAGE TAB BEGIN -->
            <el-tab-pane>
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">BackGround Image</div>
                  <i class="el-icon-picture"></i>
                </el-tooltip>
              </div>
              <!-- BACKGROUND IMAGE SETTING BEGIN -->
              <div>
                <div class="tab-content-header">BackGround Images</div>
                <div class="tab-setting-section BgColorSetting">
                  <el-switch
                    v-model="backgroundImage.enable"
                    active-text="Enabled"
                    inactive-text="Clear"
                    @change="onBgImageSwitchChange()"
                  ></el-switch>
                </div>
                <el-scrollbar wrap-class="scrollbar-wrapper">
                  <div>
                    <el-upload
                      action="#"
                      list-type="picture-card"
                      :auto-upload="false"
                      ref="bgGallery"
                    >
                      <i slot="default" class="el-icon-plus"></i>
                      <div slot="file" slot-scope="{file}" style="height:100%">
                        <img
                          class="el-upload-list__item-thumbnail"
                          :src="file.url"
                          style="object-fit: cover;"
                          alt
                        />
                        <span class="el-upload-list__item-actions" @click="applyBgImage(file)">
                          <span
                            class="el-upload-list__item-preview"
                            @click="handleBgCardPreview(file)"
                          >
                            <i class="el-icon-zoom-in"></i>
                          </span>
                          <span class="el-upload-list__item-delete" @click="handleBgRemove(file)">
                            <i class="el-icon-delete"></i>
                          </span>
                        </span>
                      </div>
                    </el-upload>
                    <el-dialog :visible.sync="BgDialogVisible">
                      <img width="100%" :src="BgDialogImageUrl" alt />
                    </el-dialog>
                  </div>
                </el-scrollbar>
              </div>
              <!-- BACKGROUND IMAGE SETTING END -->
            </el-tab-pane>
            <!-- BACKGROUND IMAGE TAB END -->

            <!-- BACKGROUND COLOR TAB BEGIN -->
            <el-tab-pane>
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">BackGround Color</div>
                  <svg-icon icon-class="tab" />
                </el-tooltip>
              </div>
              <!-- BACKGROUND COLOR SETTING BEGIN -->
              <div>
                <div class="tab-content-header">BackGround Color</div>
                <div class="tab-setting-section">
                  <div class="BgColorSetting">
                    <el-switch
                      v-model="backgroundColor.enable"
                      active-text="Enabled"
                      inactive-text="Clear"
                      @change="onBgColorSwitchChange()"
                    ></el-switch>
                    <el-color-picker
                      v-model="backgroundColor.BgColor"
                      show-alpha
                      :predefine="backgroundColor.predefineColors"
                      @change="onColorPickerChange()"
                    ></el-color-picker>
                  </div>
                  <div>
                    <el-input-number size="mini" v-model="backgroundColor.width"></el-input-number>
                    <el-input-number size="mini" v-model="backgroundColor.height"></el-input-number>
                  </div>
                </div>
                <div>
                  <div class="predefineColors">
                    <div
                      v-for="color in backgroundColor.predefineColors"
                      :key="color"
                      class="predefineColor"
                    >
                      <div
                        class="item"
                        @click="applyBgColor(color)"
                        v-bind:style="{backgroundColor: color}"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- BACKGROUND COLOR SETTING END -->
            </el-tab-pane>
            <!-- BACKGROUND COLOR TAB END -->

            <!-- TEXT TAB BEGIN -->
            <el-tab-pane>
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">Text</div>
                  <svg-icon class-name="size-icon" icon-class="size" />
                </el-tooltip>
              </div>
              <!-- TEXT SETTING BEGIN -->
              <div>
                <div class="tab-content-header">Text Setting</div>
                <div class="tab-setting-section textSetting">
                  <div>
                    <el-select
                      v-model="text.fontFamily"
                      placeholder="Select"
                      v-bind:style="{fontFamily: text.fontFamily, width: 60+'%'}"
                    >
                      <el-option
                        v-for="item in text.fontFamilies"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                        v-bind:style="{fontFamily: item.value}"
                      ></el-option>
                    </el-select>
                    <el-select v-model="text.fontSize" placeholder="Select" style="width: 36%">
                      <el-option
                        v-for="size in text.fontSizes"
                        :key="size"
                        :label="size"
                        :value="size"
                      ></el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="block">
                      <span class="demonstration">Top:</span>
                      <el-slider :max="backgroundColor.height" v-model="text.top"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="backgroundColor.width" v-model="text.left"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Line Height:</span>
                      <el-slider :max="10" v-model="text.lineHeight" style="width: 115px;"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Letter Spacing:</span>
                      <el-slider :max="20" v-model="text.letterSpacing" style="width: 115px;"></el-slider>
                    </div>
                  </div>
                  <div class="font-btns">
                    <div
                      class="font-btn"
                      v-bind:class="{ active: text.bold }"
                      @click="toggleFontStyleOfText('bold')"
                    >
                      <i class="fa fa-bold"></i>
                    </div>
                    <div
                      class="font-btn"
                      v-bind:class="{ active: text.italic }"
                      @click="toggleFontStyleOfText('italic')"
                    >
                      <i class="fa fa-italic"></i>
                    </div>
                    <div
                      class="font-btn"
                      v-bind:class="{ active: text.underline }"
                      @click="toggleFontStyleOfText('underline')"
                    >
                      <i class="fa fa-underline"></i>
                    </div>
                    <el-color-picker
                      v-model="text.color"
                      show-alpha
                      :predefine="backgroundColor.predefineColors"
                      @change="onColorPickerChange()"
                    ></el-color-picker>
                  </div>
                  <div>
                    <el-input type="textarea" placeholder="Please input" v-model="text.value"></el-input>
                  </div>
                </div>
              </div>
              <!-- TEXT SETTING END -->
            </el-tab-pane>
            <!-- TEXT TAB BEGIN -->

            <!-- PRICE TAB END -->
            <el-tab-pane>
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">Price</div>
                  <i class="el-icon-s-marketing"></i>
                </el-tooltip>
              </div>
              <!-- PRICE SETTING BEGIN -->
              <div>
                <div class="tab-content-header">Price Setting</div>
                <div class="tab-setting-section textSetting">
                  <div>
                    <el-select
                      v-model="price.fontFamily"
                      placeholder="Select"
                      v-bind:style="{fontFamily: price.fontFamily, width: 60+'%'}"
                    >
                      <el-option
                        v-for="item in price.fontFamilies"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                        v-bind:style="{fontFamily: item.value}"
                      ></el-option>
                    </el-select>
                    <el-select v-model="price.fontSize" placeholder="Select" style="width: 36%">
                      <el-option
                        v-for="size in price.fontSizes"
                        :key="size"
                        :label="size"
                        :value="size"
                      ></el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="block">
                      <span class="demonstration">Top:</span>
                      <el-slider :max="backgroundColor.height" v-model="price.top"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="backgroundColor.width" v-model="price.left"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Line Height:</span>
                      <el-slider :max="10" v-model="price.lineHeight" style="width: 115px;"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Letter Spacing:</span>
                      <el-slider :max="20" v-model="price.letterSpacing" style="width: 115px;"></el-slider>
                    </div>
                  </div>
                  <div class="font-btns">
                    <div
                      class="font-btn"
                      v-bind:class="{ active: price.bold }"
                      @click="toggleFontStyleOfPrice('bold')"
                    >
                      <i class="fa fa-bold"></i>
                    </div>
                    <div
                      class="font-btn"
                      v-bind:class="{ active: price.italic }"
                      @click="toggleFontStyleOfPrice('italic')"
                    >
                      <i class="fa fa-italic"></i>
                    </div>
                    <div
                      class="font-btn"
                      v-bind:class="{ active: price.underline }"
                      @click="toggleFontStyleOfPrice('underline')"
                    >
                      <i class="fa fa-underline"></i>
                    </div>
                    <el-color-picker
                      v-model="price.color"
                      show-alpha
                      :predefine="backgroundColor.predefineColors"
                      @change="onColorPickerChange()"
                    ></el-color-picker>
                  </div>
                  <div>
                    <el-input type="textarea" placeholder="Please input" v-model="price.value"></el-input>
                  </div>
                </div>
              </div>
              <!-- PRICE SETTING END -->
            </el-tab-pane>
            <!-- PRICE TAB END -->
          </el-tabs>
        </el-aside>
        <!-- SETTING BAR END -->

        <!-- CARD CONTENT WRAPPER BEGIN -->
        <el-main>
          <div class="main-board">
            <!-- MAIN CARD SETTING BEGIN -->
            <div></div>
            <!-- MAIN CARD SETTING BEGIN -->

            <!-- MAIN CARD CONTENT BEGIN -->
            <div
              id="main-content"
              v-bind:style="{
                backgroundImage:'url('+backgroundImage.value+')', backgroundColor: backgroundColor.BgColor,
                width: backgroundColor.width+'px',
                height: backgroundColor.height+'px',
              }"
              class="display-center"
            >
              <!-- CARD LOGO ITEM BEGIN -->
              <div
                class="card-item"
                id="logo"
                v-bind:style="{top: logo.top+'px', left: logo.left+'px', width: logo.width+'%'}"
              >
                <img :src="logo.url" alt />
              </div>
              <!-- CARD lOGO ITEM END -->

              <!-- CARD TEXT ITEM BEGIN -->
              <div
                class="card-item"
                id="text"
                v-bind:style="{
                  fontFamily: text.fontFamily,
                  fontWeight: (text.bold ? 'bold':'unset'),
                  fontStyle: (text.italic ? 'italic':'unset'),
                  textDecoration: (text.underline ? 'underline':'unset'),
                  lineHeight: text.lineHeight,
                  letterSpacing: text.letterSpacing+'px',
                  fontSize: text.fontSize+'px',
                  top: text.top+'px',
                  left: text.left+'px',
                  color: text.color,
                }"
              >{{text.value}}</div>
              <!-- CARD TEXT ITEM END -->

              <!-- CARD PRICE ITEM BEGIN -->
              <div
                class="card-item"
                id="price"
                v-bind:style="{
                  fontFamily: price.fontFamily,
                  fontWeight: (price.bold ? 'bold':'unset'),
                  fontStyle: (price.italic ? 'italic':'unset'),
                  priceDecoration: (price.underline ? 'underline':'unset'),
                  lineHeight: price.lineHeight,
                  letterSpacing: price.letterSpacing+'px',
                  fontSize: price.fontSize+'px',
                  top: price.top+'px',
                  left: price.left+'px',
                  color: price.color,
                }"
              >{{price.value}}</div>
              <!-- CARD PRICE ITEM END -->
            </div>
          </div>
        </el-main>
      </el-container>
    </div>
  </div>
</template>

<script>
export default {
  name: "GiftCardCreator",
  components: {},
  directives: {},
  filters: {},
  data() {
    return {
      tabPosition: "left",
      loading: false,
      logoDialogImageUrl: "", // LOGO IMAGE PREVIEW IN MODAL
      logoDialogVisible: false, // INDECATE IMAGE SHOW OR HIDE ON LOGO PREVIEW MODAL
      BgDialogImageUrl: "", // BACKGROUND IMAGE PREVIEW IN MODAL
      BgDialogVisible: false, // INDECATE IMAGE SHOW OR HIDE ON BACKGROUND PREVIEW MODAL
      logo: {
        top: 30,
        left: 40,
        width: 10,
        enable: true,
        url: "" // URL OF CARD LOGO
      }, // SETTINGS OF LOGO
      backgroundImage: {
        value: null, // CURRENT BACKGROUND IMAGE VALUE OF CARD
        enable: true // INDECATE ENABLE OR DISABLE OF BACKGROUND IMAGE SETTING
      },
      backgroundColor: {
        width: 1000,
        height: 800,
        BgColor: "rgba(30, 144, 255, 1)", // CURRENT BACKGROUND COLOR VALUE OF CARD
        enable: true, // INDECATE ENABLE OR DISABLE OF BACKGROUND COLOR SETTING
        predefineColors: [
          // PREDEFINED COLORS FOR COLOR PICKER
          "#ff4500",
          "#ff8c00",
          "#ffd700",
          "#90ee90",
          "#00ced1",
          "#1e90ff",
          "#c71585",
          "rgba(255, 69, 0, 0.68)",
          "rgb(255, 120, 0)",
          "hsl(181, 100%, 37%)"
        ]
      },
      text: {
        // SETTINGS FOR TEXT OF CARD
        fontFamilies: [
          {
            value: "auto",
            label: "auto"
          },
          {
            value: "cursive",
            label: "cursive"
          },
          {
            value: "fantasy",
            label: "fantasy"
          },
          {
            value: "monospace",
            label: "monospace"
          },
          {
            value: "sans-serif",
            label: "sans-serif"
          }
        ],
        fontFamily: "cursive",
        fontSizes: [
          6,
          8,
          10,
          12,
          14,
          16,
          18,
          20,
          24,
          30,
          36,
          48,
          60,
          72,
          96,
          120,
          144,
          192,
          240
        ],
        fontSize: 72,
        top: 170,
        left: 200,
        lineHeight: 1,
        letterSpacing: 0,
        bold: false,
        italic: false,
        underline: false,
        value: "Hello World !!!",
        color: "#fff"
      },
      price: {
        // SETTINGS FOR PRICE OF CARD
        fontFamilies: [
          {
            value: "auto",
            label: "auto"
          },
          {
            value: "cursive",
            label: "cursive"
          },
          {
            value: "fantasy",
            label: "fantasy"
          },
          {
            value: "monospace",
            label: "monospace"
          },
          {
            value: "sans-serif",
            label: "sans-serif"
          }
        ],
        fontFamily: "fantasy",
        fontSizes: [
          6,
          8,
          10,
          12,
          14,
          16,
          18,
          20,
          24,
          30,
          36,
          48,
          60,
          72,
          96,
          120,
          144,
          192,
          240
        ],
        fontSize: 96,
        top: 260,
        left: 300,
        lineHeight: 1,
        letterSpacing: 0,
        bold: false,
        italic: false,
        underline: false,
        value: "$150",
        color: "#fff"
      }
    };
  },
  created() {},
  methods: {
    // LOGO ACTIONS BEGIN
    handleLogoRemove(file, fileList) {
      console.log(file, fileList);
    },
    handleLogoPreview(file) {
      this.logoDialogImageUrl = file.url;
      this.logoDialogVisible = true;
    },
    applyLogo(file) {
      var toolBtnDels = document.getElementsByClassName("el-icon-delete");
      var toolBtnZooms = document.getElementsByClassName("el-icon-zoom-in");
      if (event.target == toolBtnDels[0] || event.target == toolBtnZooms[0]) {
        return;
      }
      console.log(file);
      this.logo.enable = true;
      this.logo.url = file.url;
    },
    onLogoSwitchChange() {
      if (!this.logo.enable) {
        this.logo.url = null;
      }
    },
    // LOGO ACTIONS END

    // BACKGROUND IMAGE ACTIONS BEGIN
    handleBgRemove(file) {
      console.log(file);
    },
    handleBgCardPreview(file) {
      this.BgDialogImageUrl = file.url;
      this.BgDialogVisible = true;
    },
    applyBgImage(file) {
      console.log(file);
      var toolBtnDels = document.getElementsByClassName("el-icon-delete");
      var toolBtnZooms = document.getElementsByClassName("el-icon-zoom-in");
      if (event.target == toolBtnDels[0] || event.target == toolBtnZooms[0]) {
        return;
      }
      this.backgroundImage.enable = true;
      this.backgroundImage.value = file.url;
    },
    onBgImageSwitchChange() {
      console.log(this.backgroundImage.enable);
      if (!this.backgroundImage.enable) {
        this.backgroundImage.value = null;
      }
    },
    // BACKGROUND IMAGE ACTIONS END

    // BACKGROUND COLOR ACTIONS BEGIN
    applyBgColor(color) {
      console.log(color);
      this.backgroundColor.BgColor = color;
      this.backgroundColor.enable = true;
    },
    onBgColorSwitchChange() {
      console.log(this.backgroundColor.enable);
      if (!this.backgroundColor.enable) {
        this.backgroundColor.BgColor = "rgba(0,0,0,0)";
      }
    },
    onColorPickerChange(color) {
      this.backgroundColor.enable = true;
    },
    // BACKGROUND COLOR ACTIONS END

    // TEXT ACTIONS BEGIN
    toggleFontStyleOfText(type) {
      if (type == "bold") {
        this.text.bold = !this.text.bold;
      } else if (type == "italic") {
        this.text.italic = !this.text.italic;
      } else if (type == "underline") {
        this.text.underline = !this.text.underline;
      }
    },
    // TEXT ACTIONS END

    // PRICE ACTIONS BEGIN
    toggleFontStyleOfPrice(type) {
      if (type == "bold") {
        this.price.bold = !this.price.bold;
      } else if (type == "italic") {
        this.price.italic = !this.price.italic;
      } else if (type == "underline") {
        this.price.underline = !this.price.underline;
      }
    }
    // PRICE ACTIONS END
  }
};
</script>
<style lang="scss">
.giftcreator-wrapper {
  background-color: black;
  height: 100%;

  .giftcard-creator {
    height: 93%;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;

    .el-tabs--left {
      height: 100%;
    }
    .el-container:nth-child(2) {
      height: 100%;
    }
    .el-aside {
      background-color: transparent;
      border: 3px solid #1d1d2a;
      width: 375px !important;
      padding-left: 0;
      padding-right: 8px;
      margin-bottom: 0;
    }
    .el-main {
      border: 3px solid #1d1d2a;
    }
    .tab-label {
      padding-top: 6px;
      text-align: center;

      i {
        font-size: 40px;
      }
      svg {
        font-size: 32px;
      }
    }
    .el-scrollbar__thumb {
      background: white !important;
      left: 2px !important;
    }
    .display-center {
      position: relative;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .el-tabs__item {
      height: 70px;
      display: flex !important;
      justify-content: center;
      align-items: center;
    }
    .el-tabs--left .el-tabs__active-bar.is-left {
      right: auto;
      left: auto;
      width: 4px;
    }
    .el-upload-list--picture-card .el-upload-list__item,
    .el-upload.el-upload--picture-card {
      width: 125px;
      height: 125px;
    }
    .el-upload.el-upload--picture-card .el-icon-plus {
      vertical-align: super;
    }
    .el-tab-pane {
      padding-left: 6px;
      padding-top: 6px;
    }
    .el-upload-list__item-actions {
      cursor: alias;
    }
    .tab-content-header {
      height: 48px;
      margin-bottom: 17px;
      color: white;
      text-align: center;
      font-family: cursive;
      font-size: 19px;
      border-bottom: 1px solid white;
    }
    .tab-setting-section {
      margin-bottom: 30px;

      .el-slider {
        width: 190px;
        display: inline-block;
        position: absolute;
        right: 8px;
      }
      .demonstration {
        display: inline-block;
        position: relative;
        top: 2px;
        color: snow;
        font-weight: bold;
        letter-spacing: 1px;
      }
    }
    .textSetting > div {
      margin-bottom: 50px;
    }
    .textSetting .block {
      margin-bottom: 10px;
    }
    .BgColorSetting {
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      padding: 0 18px;
      align-items: center;

      .el-color-picker {
      }
    }
    .predefineColors {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;

      .predefineColor {
        width: 125px;
        height: 125px;
        display: inline-block;
        padding: 1px;
        border: 1px solid white;
        border-radius: 3px;
        margin-bottom: 10px;

        .item {
          width: 100%;
          height: 100%;
          cursor: pointer;
        }
      }
    }
    .font-btns {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;

      .font-btn {
        width: 32px;
        height: 32px;
        background: #19272d;
        text-align: center;
        border-radius: 5px;
        color: #9e9e9e;
        cursor: pointer;
      }
      .font-btn.active {
        background: #1890ff;
        color: white;
      }
    }
    .main-board {
      height: 100%;
      width: 100%;

      #main-content {
        background-size: cover;
        background-repeat: no-repeat;
        width: 800px;
        height: 500px;
        overflow: hidden;

        .card-item {
          position: absolute;
        }
        #logo {
          top: 100px;
          left: 100px;

          img {
            width: 100%;
            height: 100%;
          }
        }
      }
    }
  }
}
</style>
