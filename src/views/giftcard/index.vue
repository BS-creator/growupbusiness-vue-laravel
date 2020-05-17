<template>
  <div class="app-container">
    <div class="giftcard">
      <div class="filter-container">
        <el-button
          class="filter-item"
          style="margin-left: 10px;"
          type="primary"
          icon="el-icon-plus"
          @click="goToCreator()"
        >Create New GiftCard</el-button>
      </div>
      <el-table
        :key="tableKey"
        v-loading="listLoading"
        :data="giftCards"
        border
        fit
        highlight-current-row
        style="width: 100%;"
      >
        <el-table-column label="No" prop="id" sortable="custom" align="center" width="80">
          <template slot-scope="{row,$index}">
            <span>{{ $index+1 }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Logo" align="center" width="150">
          <template slot-scope="{row}">
            <el-image :src="row.logo | logoFilter" class="card-logo">
              <div slot="error" class="image-slot">
                <i class="el-icon-picture-outline-round" />
              </div>
            </el-image>
          </template>
        </el-table-column>
        <el-table-column label="Text">
          <template slot-scope="{row}">
            <span>{{ row.text | textFilter }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Price">
          <template slot-scope="{row}">
            <span>{{ row.price | priceFilter }}</span>
          </template>
        </el-table-column>
        <el-table-column
          label="Actions"
          align="center"
          width="230"
          class-name="small-padding fixed-width"
        >
          <template slot-scope="{row}">
            <el-button
              type="primary"
              icon="el-icon-edit"
              size="mini"
              @click="handleUpdate(row)"
            >Edit</el-button>
            <el-button
              size="mini"
              icon="el-icon-remove-outline"
              type="danger"
              @click="handleDelete(row.id)"
            >Delete</el-button>
          </template>
        </el-table-column>
      </el-table>

      <pagination
        v-show="total>0"
        :total="total"
        :page.sync="listQuery.page"
        :limit.sync="listQuery.limit"
        @pagination="getCards"
      />
    </div>
  </div>
</template>

<script>
import waves from "@/directive/waves"; // waves directive
import Pagination from "@/components/Pagination"; // secondary package based on el-pagination
import { parseTime } from "@/utils";
import { mapGetters } from "vuex";

export default {
  name: "GiftCard",
  components: { Pagination },
  directives: { waves },
  filters: {
    logoFilter(logo) {
      var parsedLogo = JSON.parse(logo);
      return parsedLogo.url;
    },
    priceFilter(price) {
      var parsedPrice = JSON.parse(price);
      return parsedPrice.value;
    },
    textFilter(text) {
      var parsedText = JSON.parse(text);
      return parsedText.value;
    }
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10
      },
      sortOptions: [
        { label: "ID Ascending", key: "+id" },
        { label: "ID Descending", key: "-id" }
      ]
    };
  },
  computed: {
    ...mapGetters(["giftCards"])
  },
  created() {
    this.$store.dispatch("giftLogo/clearLogos");
    this.getCards();
  },
  methods: {
    // get giftcards
    async getCards() {
      await this.$store.dispatch("giftCard/get");
      this.listLoading = false;
      this.total = this.giftCards.length;
    },
    async handleUpdate(card) {
      await this.$store.dispatch("giftCard/setActiveCard", card);
      this.$router.push({
        path: this.redirect || "/gift-card/editor"
      });
    },
    handleDelete(cardId) {
      var that = this;
      this.$confirm(
        "This will permanently delete the card. Continue?",
        "Warning",
        {
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          type: "warning",
          customClass: "confirmRemoveBox"
        }
      )
        .then(() => {
          that.$store.dispatch("giftCard/remove", { id: cardId });
        })
        .catch(() => {});
    },
    handleFilter() {},
    async goToCreator() {
      await this.$store.dispatch("giftCard/setActiveCard", null);
      this.$router.push({
        path: this.redirect || "/gift-card/creator"
      });
    }
  }
};
</script>

<style lang="scss">
.giftcard {
  .card-logo {
    width: 40px;
    height: 40px;

    i {
      font-size: 40px;
    }
  }
  .el-message-box.confirmRemoveBox {
    transform: translate(0px, -50%);
  }
}
</style>
