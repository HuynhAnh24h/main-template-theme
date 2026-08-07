const { exec } = require('child_process');
const path = require('path');
const fs = require('fs');

const srcDir = path.join(__dirname, 'src');
let buildTimeout = null;
let isBuilding = false;

console.log('==================================================');
console.log('Custom File Watcher Started!');
console.log(`Monitoring changes in: ${srcDir}`);
console.log('==================================================');

// Thực hiện build lần đầu tiên khi chạy script
runBuild();

// Sử dụng hàm watch có sẵn của Node.js (hỗ trợ đệ quy trên Windows)
fs.watch(srcDir, { recursive: true }, (eventType, filename) => {
  if (filename) {
    // Chỉ build lại nếu tệp tin thay đổi là JS hoặc CSS
    if (filename.endsWith('.js') || filename.endsWith('.css')) {
      console.log(`[Thay đổi] Phát hiện thay đổi tại: ${filename}`);
      
      // Chống dội (Debounce) để tránh build liên tục khi lưu nhiều file cùng lúc
      clearTimeout(buildTimeout);
      buildTimeout = setTimeout(() => {
        if (!isBuilding) {
          runBuild();
        }
      }, 300);
    }
  }
});

function runBuild() {
  isBuilding = true;
  console.log('Đang biên dịch assets...');
  const start = Date.now();
  
  exec('npx vite build', (err, stdout, stderr) => {
    isBuilding = false;
    if (err) {
      console.error('Biên dịch thất bại:', stderr);
      return;
    }
    
    // In kết quả biên dịch ngắn gọn ra terminal
    console.log(stdout.trim());
    const duration = ((Date.now() - start) / 1000).toFixed(2);
    console.log(`Biên dịch thành công trong ${duration} giây.`);
    console.log('--------------------------------------------------');
  });
}
