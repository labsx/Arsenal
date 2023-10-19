import axios from "axios";
import toastr from 'toastr'; 
import 'toastr/build/toastr.min.css'; 

export default {
  data() {
    return {
      form: {
        first_name: "",
        last_name: "",
        position: "",
      },
      errors: {},
    };
  },
  methods: {
    async createEmployee() {
      try {
        const response = await axios.post("/employee", this.form);
        console.log("Employee created successfully:", response.data);
        this.clearForm();
        $("#addEmployee").modal("hide");
        toastr.success("Employee created successfully");
        this.errors = {};
        //this.getEmployeeFn();
  
      } catch (error) {
        if (error.response?.data) {
          this.errors = error.response.data.errors; 
        } else {
          console.error("Failed to create employee:", error);
        }
      }
    },
    clearForm() {
      this.form.first_name = "";
      this.form.last_name = "";
      this.form.position = "";
    },
    
  },
};
