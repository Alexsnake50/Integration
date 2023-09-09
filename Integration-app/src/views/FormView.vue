<script setup>
import ValidationError from '../components/ValidationFailed.vue'
</script>

<template>
  <div>
    <form @submit.prevent="submitForm" v-if="!formSubmitted && !validationFailed">
      <span>Имя</span><br>
      <input 
        v-model="name"
        type="text"
        placeholder="Введите своё имя" 
      /><br>
      <span>Email</span><br>
      <input 
        v-model="email"
        type="email"
        placeholder="Введите Email" 
      /><br>
      <span>Телефон</span><br>
      <input 
        v-model="phone"
        type="text"
        placeholder="Введите свой номер телефона" 
      /><br>
      <span>Цена сделки</span><br>
      <input 
        v-model="price"
        type="text"
        placeholder="Введите цену сделки" 
      /><br>
      <br>
      <input 
        class="submit" 
        type="submit" 
        value="Отправить"
      >
    </form>
    <div v-if="formSubmitted">
      <h3>Отправленная форма</h3>
      <p>Имя: {{ name }}</p>
      <p>Email: {{ email }}</p>
      <p>Телфон: {{ phone }}</p>
      <p>Цена сделки: {{ price }}</p>
    </div>
    <div v-if="validationFailed">
      <ValidationError/>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        name: "",
        email: "",
        phone: "",
        price: "",
        formSubmitted: false,
        validationFailed: false,
      };
    },
    methods: {
      submitForm: function () {
        if(this.validateForm){
          fetch('http://integration/Integration-back-end/integration.php',{
          method:"post",
          body:JSON.stringify({name: this.name, email: this.email, phone: this.phone, price: this.price})
        }).then(function(data){
          console.log(data);
        })
          this.formSubmitted = true
        }
        else{
          this.validationFailed = true
        }
      },
      validateForm: function () {
        if(this.name && this.email && this.phone && this.price){
          return true;
        }
        else{
          return false;
        }
      }
    },
  };
</script>
<style>
  form {
    padding: 10px;
    border: 2px solid black;
    border-radius: 5px;
  }

  input {
    padding: 4px 8px;
    margin: 4px;
  }

  span {
    font-size: 18px;
    margin: 4px;
    font-weight: 500;
  }

  .submit {
    font-size: 15px;
    color: #fff;
    background: #222;
    padding: 6px 12px;
    border: none;
    margin-top: 8px;
    cursor: pointer;
    border-radius: 5px;
  }

</style>