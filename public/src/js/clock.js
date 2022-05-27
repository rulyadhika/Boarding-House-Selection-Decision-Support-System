const clockDisplay = document.querySelector(".clockDisplay");
const dateDisplay = document.querySelector(".dateDisplay");
// const waktu = document.querySelector(".waktu");

function showTime() {
  // let days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
  // let months = [
  //   "Januari",
  //   "Februari",
  //   "Maret",
  //   "April",
  //   "Mei",
  //   "Juni",
  //   "Juli",
  //   "Augustus",
  //   "September",
  //   "Oktober",
  //   "November",
  //   "Desember",
  // ];

  let calender = new Date();
  let date = calender.toLocaleDateString("id", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });
  // let date = calender.getDate();
  // let day = days[calender.getDay()];
  // let month = months[calender.getMonth()];
  // let year = calender.getFullYear();
  let hour = calender.getHours();
  let minutes = calender.getMinutes();
  let second = calender.getSeconds();

  // if (hour >= 0 && hour < 12) {
  //   waktu.innerHTML = "PAGI";
  // } else if (hour >= 12 && hour < 18) {
  //   waktu.innerHTML = "SIANG";
  // } else {
  //   waktu.innerHTML = "MALAM";
  // }

  clockDisplay.innerHTML = `${hour} : ${minutes} : ${second} WIB`;
  dateDisplay.innerHTML = date;
}

setInterval(() => {
  showTime();
}, 1000);
