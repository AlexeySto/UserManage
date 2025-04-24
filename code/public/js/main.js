// Функция для обновления времени
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('ru-RU');
    document.getElementById('current-time').textContent = timeString;
}
// Обновлять время каждую секунду
setInterval(updateTime, 1000);
updateTime(); // Также обновляем сразу