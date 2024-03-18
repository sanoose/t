<script setup>
import { onMounted } from "@vue/runtime-core";
import TreeView from "@/Components/TreeView.vue";
import { Link  } from "@inertiajs/vue3";
 
const props = defineProps({
  id: {
    type: String,
    //default: "tree-" + Math.random().toString(36).substr(2, 9),
  },
  data: Object,
  editRoute: String,
});

onMounted(() => {

  // console.log(props.id, window.jQuery(`#${props.id}`));

  window.jQuery(`#${props.id}`).treed({
    openedClass: "open-icon",
    closedClass: "close-icon",
  });
});

</script>
<template>
  <ul :id="props.id ?? ''">
    <li v-for="row , i  in data" :key="row" class="branch-head">
      {{ row?.name }}
      <!-- <div class=""> -->
      <Link 
        class="btn btn-sm node-action"
        :href="route(props?.editRoute, { id: row?.id })"
        >تعديل</Link
      >
      <!-- </div> -->
      <TreeView
        v-if="row?.children?.length > 0"
        :data="row.children"
        :editRoute="props?.editRoute"
      ></TreeView>
    </li>
  </ul>
  <!-- <ul :id="props.id">
    <li>
      <a href="#">TECH</a>
      <ul>
        <li>Company Maintenance</li>
        <li>
          Employees
          <ul>
            <li>
              Reports
              <ul>
                <li>Report1</li>
                <li>Report2</li>
                <li>Report3</li>
              </ul>
            </li>
            <li>Employee Maint.</li>
          </ul>
        </li>
        <li>Human Resources</li>
      </ul>
    </li>
  </ul> -->
</template>

<style scoped>
.tree,
.tree ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.tree ul {
  margin-right: 1em;
  position: relative;
}

.tree ul ul {
  margin-left: 0.5em;
}

.tree ul:before {
  content: "";
  display: block;
  width: 0;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  border-left: 1px solid;
}

.tree li {
  margin: 0;
  padding: 0 1em;
  line-height: 2em;
  color: #369;
  font-weight: 700;
  position: relative;
}

.node-action {
  visibility: hidden;
}

.tree li:hover > .node-action {
  visibility: visible;
}

.tree ul li:before {
  content: "";
  display: block;
  width: 10px;
  height: 0;
  border-top: 1px solid;
  margin-top: -1px;
  position: absolute;
  top: 1em;
  right: 0;
}

.tree ul li:last-child:before {
  background: #fff;
  height: auto;
  top: 1em;
  bottom: 0;
}

.indicator {
  margin-right: 5px;
}

.tree li a {
  text-decoration: none;
  color: #369;
}

.tree li button,
.tree li button:active,
.tree li button:focus {
  text-decoration: none;
  color: #369;
  border: none;
  background: transparent;
  margin: 0px 0px 0px 0px;
  padding: 0px 0px 0px 0px;
  outline: 0;
}

.branch .plus:before {
  font-style: normal;
  font-family: "FontAwesome";
  content: "\f067";
}

.branch .minus:before {
  font-style: normal;
  font-family: "FontAwesome";
  content: "\f068";
}
</style>

<style>
.open-icon {
  display: inline-block;
  text-indent: -9999px;
  width: 12px;
  height: 12px;
  background: url("/svg/minus.svg") no-repeat;
  background-size: 12px 12px;
  cursor: pointer;
}

.close-icon {
  display: inline-block;
  text-indent: -9999px;
  width: 12px;
  height: 12px;
  background: url("/svg/plus.svg") no-repeat;
  background-size: 12px 12px;
  cursor: pointer;
}
</style>
