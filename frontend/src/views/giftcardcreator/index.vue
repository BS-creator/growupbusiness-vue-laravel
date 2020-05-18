<template>
  <div class="app-container creator-wrapper">
    <el-container>
      <el-header>
        <div style="display: flex;justify-content: space-between;">
          <div>
            <router-link to="/gift-card">
              <el-button
                :loading="loading"
                type="primary"
                class="login-btn"
                size="large"
                icon="el-icon-arrow-left"
              >GO BACK</el-button>
            </router-link>
          </div>
          <!-- MAIN CARD SETTING BEGIN -->
          <!-- <div>
            <div>
              <span class="demonstration">W:</span>
              <el-input-number size="mini" v-model="backgroundColor.width" style="width:100px"></el-input-number>
              <span class="demonstration" style="margin-left:18px;">H:</span>
              <el-input-number size="mini" v-model="backgroundColor.height" style="width:100px"></el-input-number>
            </div>
          </div>-->
          <!-- MAIN CARD SETTING BEGIN -->
          <div>
            <el-button
              :loading="loading"
              type="primary"
              class="login-btn"
              size="large"
              style="float: right;"
              @click="downloadGiftCard()"
              icon="el-icon-download"
            >DOWNLOAD</el-button>
            <el-button
              :loading="loading"
              type="primary"
              class="login-btn"
              size="large"
              style="float: right; margin-right: 20px;"
              @click="saveGiftCard()"
              icon="el-icon-check"
            >
              <span v-if="isEditor">UPDATE CARD</span>
              <span v-else>SAVE CARD</span>
            </el-button>
          </div>
        </div>
      </el-header>
    </el-container>
    <div class="giftcard-creator">
      <el-container></el-container>
      <el-container>
        <!-- SETTING BAR BEGIN -->
        <el-aside>
          <!-- SETTING BAR TAB BEGIN -->
          <el-tabs :tab-position="tabPosition" v-model="tabActive">
            <!-- LOGO TAB BEGIN -->
            <el-tab-pane name="logoimgtab">
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
                      <el-slider :min="-100" :max="100" v-model="logo.top" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="100" v-model="logo.left" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Size:</span>
                      <el-slider :max="100" v-model="logo.width" :step="0.1"></el-slider>
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
                  <div id="test" style="height: 555px;">
                    <el-upload
                      action="#"
                      list-type="picture-card"
                      :on-change="handleLogoChange"
                      :file-list="giftLogos"
                      :auto-upload="false"
                    >
                      <i class="el-icon-plus"></i>
                      <div slot="file" slot-scope="{file}" style="height:100%">
                        <img
                          class="el-upload-list__item-thumbnail"
                          :src="file.url"
                          style="object-fit: cover;"
                          alt
                        />
                        <span class="el-upload-list__item-actions" @click="applyLogo(file)">
                          <span class="el-upload-list__item-delete" @click="handleLogoRemove(file)">
                            <i class="el-icon-delete"></i>
                          </span>
                        </span>
                      </div>
                    </el-upload>
                  </div>
                </el-scrollbar>
              </div>
              <!-- LOGO SETTING END -->
            </el-tab-pane>
            <!-- LOGO TAB END -->

            <!-- BACKGROUND IMAGE TAB BEGIN -->
            <el-tab-pane name="bgimgtab">
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
                  <div style="height: 700px;">
                    <el-upload
                      action="#"
                      list-type="picture-card"
                      :on-change="handleBgImgChange"
                      :file-list="giftBgImgs"
                      :auto-upload="false"
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
                          <span class="el-upload-list__item-delete" @click="handleBgRemove(file)">
                            <i class="el-icon-delete"></i>
                          </span>
                        </span>
                      </div>
                    </el-upload>
                  </div>
                </el-scrollbar>
              </div>
              <!-- BACKGROUND IMAGE SETTING END -->
            </el-tab-pane>
            <!-- BACKGROUND IMAGE TAB END -->

            <!-- BACKGROUND COLOR TAB BEGIN -->
            <el-tab-pane name="bgcolortab">
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">BackGround</div>
                  <svg-icon icon-class="tab" />
                </el-tooltip>
              </div>
              <!-- BACKGROUND COLOR SETTING BEGIN -->
              <div>
                <div class="tab-content-header">BackGround</div>
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
                      :predefine="predefineColors"
                      @change="onColorPickerChange()"
                    ></el-color-picker>
                  </div>
                  <div>
                    <span class="demonstration">W:</span>
                    <el-input-number
                      size="mini"
                      v-model="backgroundColor.width"
                      style="width:100px"
                    ></el-input-number>
                    <span class="demonstration" style="margin-left:18px;">H:</span>
                    <el-input-number
                      size="mini"
                      v-model="backgroundColor.height"
                      style="width:100px"
                    ></el-input-number>
                  </div>
                </div>
                <div>
                  <el-scrollbar wrap-class="scrollbar-wrapper">
                    <div class="predefineColors" style="height: 540px;">
                      <div v-for="color in predefineColors" :key="color" class="predefineColor">
                        <div
                          class="item"
                          @click="applyBgColor(color)"
                          v-bind:style="{backgroundColor: color}"
                        ></div>
                      </div>
                    </div>
                  </el-scrollbar>
                </div>
              </div>
              <!-- BACKGROUND COLOR SETTING END -->
            </el-tab-pane>
            <!-- BACKGROUND COLOR TAB END -->

            <!-- TEXT TAB BEGIN -->
            <el-tab-pane name="texttab">
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
                        v-for="item in fontFamilies"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                        v-bind:style="{fontFamily: item.value}"
                      ></el-option>
                    </el-select>
                    <el-select v-model="text.fontSize" placeholder="Select" style="width: 36%">
                      <el-option v-for="size in fontSizes" :key="size" :label="size" :value="size"></el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="block">
                      <span class="demonstration">Top:</span>
                      <el-slider :min="-100" :max="100" v-model="text.top" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="100" v-model="text.left" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Line Height:</span>
                      <el-slider :max="10" v-model="text.lineHeight" style="width: 150px;"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Letter Spacing:</span>
                      <el-slider :max="50" v-model="text.letterSpacing" style="width: 150px;"></el-slider>
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
                      :predefine="predefineColors"
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
            <el-tab-pane name="pricetab">
              <div class="tab-label" slot="label">
                <el-tooltip effect="light" placement="right">
                  <div slot="content">Price</div>
                  <svg-icon icon-class="money" />
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
                        v-for="item in fontFamilies"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                        v-bind:style="{fontFamily: item.value}"
                      ></el-option>
                    </el-select>
                    <el-select v-model="price.fontSize" placeholder="Select" style="width: 36%">
                      <el-option v-for="size in fontSizes" :key="size" :label="size" :value="size"></el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="block">
                      <span class="demonstration">Top:</span>
                      <el-slider :min="-100" :max="100" v-model="price.top" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Left:</span>
                      <el-slider :max="100" v-model="price.left" :step="0.1"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Line Height:</span>
                      <el-slider :max="10" v-model="price.lineHeight" style="width: 115px;"></el-slider>
                    </div>
                    <div class="block">
                      <span class="demonstration">Letter Spacing:</span>
                      <el-slider :max="50" v-model="price.letterSpacing" style="width: 115px;"></el-slider>
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
                      :predefine="predefineColors"
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
            <!-- MAIN CARD CONTENT BEGIN -->
            <div
              id="main-content"
              @click="switchTab('bgcolortab')"
              v-bind:style="{
                backgroundImage:'url('+backgroundImage.value+')', backgroundColor: backgroundColor.BgColor,
                width: backgroundColor.width+'px',
                height: backgroundColor.height+'px',
              }"
            >
              <!-- CARD LOGO ITEM BEGIN -->
              <div
                class="card-item"
                @click="switchTab('logoimgtab')"
                id="logo"
                v-bind:style="{top: logo.top+'%', left: logo.left+'%', width: logo.width+'%'}"
              >
                <img :src="logo.url" alt />
              </div>
              <!-- CARD lOGO ITEM END -->

              <!-- CARD TEXT ITEM BEGIN -->
              <pre
                class="card-item"
                @click="switchTab('texttab')"
                id="text"
                v-bind:style="{
                  fontFamily: text.fontFamily,
                  fontWeight: (text.bold ? 'bold':'unset'),
                  fontStyle: (text.italic ? 'italic':'unset'),
                  textDecoration: (text.underline ? 'underline':'unset'),
                  lineHeight: text.lineHeight,
                  letterSpacing: text.letterSpacing+'px',
                  fontSize: text.fontSize+'px',
                  top: text.top+'%',
                  left: text.left+'%',
                  color: text.color,
                }"
              >{{text.value}}</pre>
              <!-- CARD TEXT ITEM END -->

              <!-- CARD PRICE ITEM BEGIN -->
              <pre
                class="card-item"
                @click="switchTab('pricetab')"
                id="price"
                v-bind:style="{
                  fontFamily: price.fontFamily,
                  fontWeight: (price.bold ? 'bold':'unset'),
                  fontStyle: (price.italic ? 'italic':'unset'),
                  textDecoration: (price.underline ? 'underline':'unset'),
                  lineHeight: price.lineHeight,
                  letterSpacing: price.letterSpacing+'px',
                  fontSize: price.fontSize+'px',
                  top: price.top+'%',
                  left: price.left+'%',
                  color: price.color,
                }"
              >{{price.value}}</pre>
              <!-- CARD PRICE ITEM END -->
            </div>
          </div>
        </el-main>
      </el-container>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "GiftCardCreator",
  components: {},
  directives: {},
  filters: {},
  data() {
    return {
      isEditor: false, // INDECATE WHETHER IT's EDIT OR CREATE STATUS
      logosLoading: true,
      tabPosition: "left",
      tabActive: "logoimgtab",
      loading: false,
      logoDialogImageUrl: "", // LOGO IMAGE PREVIEW IN MODAL
      logoDialogVisible: false, // INDECATE IMAGE SHOW OR HIDE ON LOGO PREVIEW MODAL
      BgDialogImageUrl: "", // BACKGROUND IMAGE PREVIEW IN MODAL
      BgDialogVisible: false, // INDECATE IMAGE SHOW OR HIDE ON BACKGROUND PREVIEW MODAL
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
      ],
      logo: {
        id: 0,
        top: 5,
        left: 5,
        width: 10,
        enable: true,
        url: "" // URL OF CARD LOGO
      }, // SETTINGS OF LOGO
      backgroundImage: {
        id: 0,
        value: null, // CURRENT BACKGROUND IMAGE VALUE OF CARD
        enable: true // INDECATE ENABLE OR DISABLE OF BACKGROUND IMAGE SETTING
      },
      backgroundColor: {
        width: 1000,
        height: 500,
        BgColor: "rgba(30, 144, 255, 1)", // CURRENT BACKGROUND COLOR VALUE OF CARD
        enable: true // INDECATE ENABLE OR DISABLE OF BACKGROUND COLOR SETTING
      },
      text: {
        // SETTINGS FOR TEXT OF CARD
        fontFamily: "cursive",
        fontSize: 72,
        top: 10,
        left: 27,
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
        fontFamily: "fantasy",
        fontSize: 96,
        top: 10,
        left: 40,
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
  computed: {
    ...mapGetters(["giftLogos", "giftBgImgs", "activeGiftCard"])
  },
  created() {
    this.getLogos();
    this.getBgImgs();
    this.applyActiveCard();
  },
  mounted() {},
  methods: {
    // GLOBAL ACTIONS BEGIN
    switchTab(tabName) {
      var mainContent = document.getElementById("main-content");
      if (tabName == "bgcolortab") {
        if (event.target != mainContent) {
          return;
        } else if (this.backgroundImage.value != null) {
          this.tabActive = "bgimgtab";
          return;
        }
      }
      this.tabActive = tabName;
    },
    // HANDLE GIFT CARD BEGIN
    applyActiveCard() {
      console.log("activeGiftCard", this.activeGiftCard);
      console.log(this.$route);
      if (this.$route.name != "GiftsEditor") {
        return;
      } else if (this.activeGiftCard == null) {
        this.$router.push({
          path: this.redirect || "/gift-card"
        });
        return;
      }
      this.isEditor = true;
      this.backgroundImage = JSON.parse(this.activeGiftCard.backgroundImage);
      this.backgroundColor = JSON.parse(this.activeGiftCard.backgroundColor);
      this.logo = JSON.parse(this.activeGiftCard.logo);
      this.text = JSON.parse(this.activeGiftCard.text);
      this.price = JSON.parse(this.activeGiftCard.price);
    },
    updateGiftCard() {
      // console.log("getCardById");
      // await this.$store.dispatch("giftCard/getOne")
    },
    saveGiftCard() {
      var card = {
        id: this.activeGiftCard ? this.activeGiftCard.id : "",
        logo: JSON.stringify(this.logo),
        backgroundImage: JSON.stringify(this.backgroundImage),
        backgroundColor: JSON.stringify(this.backgroundColor),
        text: JSON.stringify(this.text),
        price: JSON.stringify(this.price)
      };
      this.$store
        .dispatch("giftCard/store", card)
        .then(() => {
          this.$message({
            message:
              "Gift Card " +
              (this.isEditor ? "updated" : "saved") +
              " successfully",
            type: "success"
          });
        })
        .catch(e => {});
    },
    downloadGiftCard() {
      console.log("saving . . .");
      if (this.logo.url != null || this.backgroundImage.value != null) return;
      var cardContainer = document.getElementById("main-content");
      var that = this;
      html2canvas(cardContainer, { allowTaint: true }).then(function(canvas) {
        console.log(canvas);
        var myImage = canvas.toDataURL("image/jpg");
        that.downloadURI("data:" + myImage, "Gift Card.jpg");
      });
    },
    downloadURI(uri, name) {
      var link = document.createElement("a");
      link.download = name;
      link.href = uri;
      link.click();
    },
    // HANDLE GIFT CARD END
    // GLOBAL ACTIONS END

    // LOGO ACTIONS BEGIN
    // upload logo
    handleLogoChange(file, fileList) {
      var logo = {
        name: file.name,
        type: file.raw.type.split("/")[1],
        uid: file.uid
      };
      var that = this;
      var reader = new FileReader();
      reader.readAsDataURL(file.raw);
      reader.onloadend = function() {
        var base64data = reader.result;
        logo.content = base64data;

        that.$store
          .dispatch("giftLogo/store", logo)
          .then(() => {
            that.$message({
              message: "Logo uploaded successfully",
              type: "success"
            });
          })
          .catch(e => {});
      };
    },
    // get logos
    async getLogos() {
      await this.$store.dispatch("giftLogo/get");
      setTimeout(() => {
        this.logosLoading = false;
      }, 1.5 * 1000);
    },
    // remove logo
    handleLogoRemove(file) {
      console.log(file);
      var that = this;
      var selectedLogo = false;
      if (this.logo.id == file.id) {
        selectedLogo = true;
      }
      this.$confirm(
        selectedLogo
          ? "This logo is used currently. Continue? "
          : "This will permanently delete the logo. Continue?",
        "Warning",
        {
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          type: "warning",
          customClass: "confirmRemoveBox"
        }
      )
        .then(() => {
          if (selectedLogo) that.logo.url = null;
          that.$store
            .dispatch("giftLogo/remove", { id: file.id })
            .then(() => {})
            .catch(err => {
              // that.$message({ type: "warning", message: err });
            });
        })
        .catch(() => {});
    },
    // apply clicked logo
    applyLogo(file) {
      var classnames = ["el-icon-delete", "el-upload-list__item-delete"];
      if (classnames.indexOf(event.target.className) != -1) {
        // when click remove btn
        return;
      }
      this.logo.enable = true;
      this.logo.url = file.url;
      this.logo.id = file.id;
    },
    // enable/disable logo
    onLogoSwitchChange() {
      if (!this.logo.enable) {
        this.logo.url = null;
        this.logo.id = 0;
      }
    },
    // LOGO ACTIONS END

    // BACKGROUND IMAGE ACTIONS BEGIN
    // upload bgimg
    handleBgImgChange(file) {
      var bgImg = {
        name: file.name,
        type: file.raw.type.split("/")[1],
        uid: file.uid
      };
      var that = this;
      var reader = new FileReader();
      reader.readAsDataURL(file.raw);
      reader.onloadend = function() {
        var base64data = reader.result;
        bgImg.content = base64data;

        that.$store
          .dispatch("giftBgImg/store", bgImg)
          .then(() => {
            that.$message({
              message: "BackGround Image uploaded successfully",
              type: "success"
            });
          })
          .catch(e => {});
      };
    },
    // get bgimgs
    async getBgImgs() {
      await this.$store.dispatch("giftBgImg/get");
    },
    handleBgRemove(file) {
      console.log(file);
      var that = this;
      var selectedBgImg = false;
      if (this.logo.id == file.id) {
        selectedBgImg = true;
      }
      this.$confirm(
        selectedBgImg
          ? "This image is used currently. Continue?"
          : "This will permanently delete the image. Continue?",
        "Warning",
        {
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          type: "warning",
          customClass: "confirmRemoveBox"
        }
      )
        .then(() => {
          if (selectedBgImg) that.backgroundImage.value = null;
          that.$store
            .dispatch("giftBgImg/remove", { id: file.id })
            .then(() => {})
            .catch(err => {
              // that.$message({ type: "warning", message: err });
            });
        })
        .catch(() => {});
    },
    applyBgImage(file) {
      var classnames = ["el-icon-delete", "el-upload-list__item-delete"];
      if (classnames.indexOf(event.target.className) != -1) {
        // when click remove btn
        return;
      }
      this.backgroundImage.enable = true;
      this.backgroundImage.value = file.url;
      this.backgroundImage.id = file.id;
    },
    onBgImageSwitchChange() {
      console.log(this.backgroundImage.enable);
      if (!this.backgroundImage.enable) {
        this.backgroundImage.value = null;
        this.backgroundImage.id = 0;
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
.creator-wrapper {
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
    .el-upload-list__item-delete {
      position: absolute !important;
      left: 6px !important;
      width: fit-content;
      // right: 0 !important;
    }
    li.el-upload-list__item.is-ready {
      display: none;
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
        font-size: 14px;
        // font-weight: bold;
        // letter-spacing: 1px;
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
      align-items: center;

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
    textarea {
      font-size: 20px !important;
    }
    .main-board {
      height: 100%;
      width: 100%;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;

      #main-content {
        background-size: cover;
        background-repeat: no-repeat;
        width: 800px;
        height: 500px;
        overflow: hidden;
        user-select: none;
        cursor: pointer;
        margin-left: -1px;

        .card-item {
          width: fit-content;
          position: relative;
          border: 1px solid transparent;
          cursor: pointer;
        }
        .card-item:hover {
          border-color: green;
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
