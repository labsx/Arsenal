import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";
import JsBarcode from "jsbarcode";

export function itemDetails() {
  const status = ref("");
  const historyId = ref("");
  const errors = ref([]);
  const toastr = useToastr();
  const router = useRouter();
  const route = useRoute();

  const generateBarcode = (barcodeValue) => {
    const canvas = document.createElement("canvas");
    JsBarcode(canvas, barcodeValue, {
      format: "CODE128",
      displayValue: true,
    });
    return canvas.toDataURL();
  };

  const formatPrice = (price) => {
    if (!price) {
      return "none";
    }
    const parts = price.toString().split(".");
    const integerPart = parts[0]
      .split("")
      .reverse()
      .map((digit, index) => (index > 0 && index % 3 === 0 ? digit + " " : digit))
      .reverse()
      .join("");
      price = Number(price);
      return `₱ ${price.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
  };

  const form = reactive({
    name: "",
    serial: "",
    status: "",
    parent_id: "",
    id: "",
    value: [{ name: "", value: "" }],
  });

  const addAttribute = () => {
    form.value.push({ name: "", value: "" });
  };

  const removeAttribute = (index) => {
    form.value.splice(index, 1);
  };

  const getItems = () => {
    axios
      .get(`/items/${route.params.id}`)
      .then((response) => {
        console.log("Response data:", response.data);

        if (response.data) {
          form.id = response.data.id;
          form.name = response.data.name;
          form.serial = response.data.serial;
          form.status = response.data.status;
          form.model = response.data.model;
          form.mfg_date = response.data.mfg_date;
          form.price = response.data.price;
          form.location = response.data.location;
          form.manufacturer = response.data.manufacturer;
          form.warranty = response.data.warranty;
          form.net_weight = response.data.net_weight;
          form.insurance = response.data.insurance;
          status.value = form.status;
          form.barcode = response.data.barcode;
          fetchHistories();
        } else {
          console.error("Item data not found in the response.");
        }
      })
      .catch((error) => {
        console.error("Error fetching item details:", error);
      });
  };

  const getAttributes = () => {
    axios
      .get(`/items/${route.params.id}/attributes`)
      .then(({ data }) => {
        console.log("Attributes data:", data);

        if (Array.isArray(data)) {
          form.value = data.map((attribute) => ({
            name: attribute.name,
            value: attribute.value,
          }));
        } else {
          console.error("Invalid attributes data format.");
        }
      })
      .catch((error) => {
        console.error("Error fetching item attributes:", error);
      });
  };

  const histories = ref([]);
  const fetchHistories = () => {
    console.log("Fetching histories for item with ID:", form.id);

    if (form.id) {
      axios
        .get(`/historiess?item_id=${form.id}`)
        .then(async ({ data }) => {
          console.log("Histories data:", data);
          if (data.length > 0) {
            historyId.value = data[0].id;

            for (let i = 1; i < data.length; i++) {
              if (data[i].id > historyId.value) {
                historyId.value = data[i].id;
              }
            }
          }

          const fetchEmployeeDataPromises = data.map(async (history) => {
            const employeeData = await fetchEmployeeData(history.employee_id);
            if (employeeData) {
              history.employee = employeeData;
            } else {
              history.employee = { first_name: "Unknown", last_name: "Employee" };
            }
            return history;
          });

          Promise.all(fetchEmployeeDataPromises)
            .then((historiesWithEmployee) => {
              histories.value = historiesWithEmployee;
            })
            .catch((error) => {
              console.error("Error fetching employee data:", error);
            });
        })
        .catch((error) => {
          console.error("Error fetching histories data:", error);
        });
    }
  };

  const fetchEmployeeData = async (employeeId) => {
    if (!employeeId) {
      console.error("Employee ID is empty.");
      return null;
    }

    try {
      const response = await axios.get(`/employee/${employeeId}`);
      if (response.data) {
        return response.data;
      }
      return null;
    } catch (error) {
      console.error("Error fetching employee data:", error);
      return null;
    }
  };

  const calculateWarrantyRemainingDays = () => {
    if (form.warranty) {
      const warrantyDate = new Date(form.warranty);
      const currentDate = new Date();
      const timeDifference = warrantyDate - currentDate;

      const daysRemaining = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

      return daysRemaining;
    }
    return null;
  };

  onMounted(() => {
    fetchEmployeeData();
    fetchHistories();
    getItems();
    getAttributes();
  });

  return {
    fetchEmployeeData, fetchHistories, getItems, getAttributes, history, addAttribute,
    removeAttribute, form, histories, historyId, status, generateBarcode, formatPrice, calculateWarrantyRemainingDays
  };
}