<template>
  <div class="container bg-light">
    <div class="row justify-content-center">
      <div class="col-auto">
        <div class="d-flex align-items-center">
          <span class="forecast-label">5 Day Forecast for</span>
          <div class="dropdown forecast-dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              {{ selection }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li v-for="location in locations" :key="location">
                <a class="dropdown-item" @click="selection = location">{{ location }}</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-3">
      <div class="col-auto" v-if="!loading && dataLoaded">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Day</th>
              <th scope="col">Max Temp </th>
              <th scope="col">Min Temp</th>
              <th scope="col">Avg Temp</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(day, index) in days" :key="day.date">
              <td>{{ index === 0 ? 'Today' : (index === 1 ? 'Tomorrow' : getDayName(day.datetime)) }}</td>
              <td>{{ day.max_temp }} °C</td>
              <td>{{ day.min_temp }} °C</td>
              <td>{{ day.temp }} °C</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-auto" v-if="!loading && !dataLoaded">
        <div class="alert alert-warning">
          Failed to retrieve forecast data. Please try again later.
        </div>
      </div>
      <div class="col-auto" v-if="loading">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>

  </div>
</template>



<script>
import { defineComponent } from 'vue'
import axios from 'axios'

export default defineComponent({
  data() {
    return {
      forecasts: {},
      locations: [
        'Brisbane',
        'Gold Coast',
        'Sunshine Coast'
      ],
      selection: 'Brisbane',
      loading: false,
      dataLoaded: false
    }
  },
  computed: {
    days() {
      console.log(this.forecasts[this.selection]?.data || [])
      return this.forecasts[this.selection]?.data || []
    }
  },
  mounted() {
    this.loadData()
  },
  methods: {
    loadData() {
      this.loading = true
      axios.get('/api/forecast')
        .then(response => {
          this.forecasts = response.data
          this.dataLoaded = true
          this.loading = false
        })
        .catch(error => {
          console.error(error)
          this.dataLoaded = true
          this.loading = false
        })
    },
    getDayName(date) {
      const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const dayIndex = new Date(date).getDay();
      return daysOfWeek[dayIndex];
    }
  }
})
</script>

<style scoped>
.container {
  padding-top: 20px;
  max-width: 800px; /* Adjust the maximum width as needed */
  margin-left: auto;
  margin-right: auto;
}

.list-group {
  width: 100%;
}

.forecast-label {
  font-weight: bold;
}

.forecast-dropdown {
  display: inline-block;
  margin-left: 10px;
}

.dropdown-item:hover {
  cursor: pointer;
}
</style>