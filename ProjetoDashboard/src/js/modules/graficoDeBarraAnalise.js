export default function graficoDeBarraAnalise(theme) {
  
  const ctx = document.querySelector("#graficoDeBarraAnalise");
  
  if (ctx) {
      let data = [1,2,3,4,5,6,6,5,4,3,2,1,2,3,4,5,6,3,2,1,4,3,5,6,3,2,1,2,3,4,3];
      Chart.defaults.color = theme;

      let graficoBarra = new Chart(ctx, {
        type: "bar",
        data: {
          labels: [
            " Dia 01",
            " Dia 02",
            " Dia 03",
            " Dia 04",
            " Dia 05",
            " Dia 06",
            " Dia 07",
            " Dia 08",
            " Dia 09",
            " Dia 10",
            " Dia 11",
            " Dia 12",
            " Dia 13",
            " Dia 14",
            " Dia 15",
            " Dia 16",
            " Dia 17",
            " Dia 18",
            " Dia 19",
            " Dia 20",
            " Dia 21",
            " Dia 22",
            " Dia 23",
            " Dia 24",
            " Dia 25",
            " Dia 26",
            " Dia 27",
            " Dia 28",
            " Dia 29",
            " Dia 30",
            " Dia 31"
          ],
          datasets: [
            {
              label: "Gastos Diarios do Mês R$",
              data: data,
              backgroundColor: [
                "rgba(240, 248, 255, 0.7)",  
                "rgba(224, 238, 255, 0.7)",   
                "rgba(200, 220, 255, 0.7)",   
                "rgba(175, 215, 255, 0.7)",  
                "rgba(150, 200, 255, 0.7)",  
                "rgba(125, 185, 255, 0.7)",  
                "rgba(100, 170, 255, 0.7)",   
                "rgba(80, 155, 255, 0.7)",   
                "rgba(60, 140, 255, 0.7)",    
                "rgba(40, 125, 255, 0.7)",   
                "rgba(20, 110, 255, 0.7)",   
                "rgba(10, 95, 255, 0.7)"     
              ],
              borderColor: [
                "rgba(9, 248, 210, 1)",  
                "rgba(9, 238, 210, 1)",   
                "rgba(9, 220, 210, 1)",   
                "rgba(9, 215, 210, 1)",  
                "rgba(9, 200, 210, 1)",  
                "rgba(9, 185, 210, 1)",  
                "rgba(9, 170, 210, 1)",   
                "rgba(9, 155, 210, 1)",   
                "rgba(9, 140, 210, 1)",    
                "rgba(9, 125, 210, 1)",   
                "rgba(9, 110, 210, 1)",   
                "rgba(9, 9, 210, 1)"
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
  }
}