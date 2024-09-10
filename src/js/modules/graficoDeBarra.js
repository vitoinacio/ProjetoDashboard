export default function graficoDeBarra() {
  
  const ctx = document.getElementById("graficoDeBarra");

  if (ctx) {
    let data = [1,2,3,4,5,6,6,5,4,3,2,1];

  let graficoBarra = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Jan",
        "Fev",
        "Mar",
        "Abr",
        "Mai",
        "Jun",
        "Jul",
        "Ago",
        "Set",
        "Out",
        "Nov",
        "Dez"
      ],
      datasets: [
        {
          label: "Gastos mensais R$",
          data: data,
          backgroundColor: [
            "rgba(240, 248, 255, 0.7)",  // Janeiro - Alice Blue
            "rgba(224, 238, 255, 0.7)",  // Fevereiro - Light Sky Blue
            "rgba(200, 220, 255, 0.7)",  // Março - Light Steel Blue
            "rgba(175, 215, 255, 0.7)",  // Abril - Light Blue
            "rgba(150, 200, 255, 0.7)",  // Maio - Sky Blue
            "rgba(125, 185, 255, 0.7)",  // Junho - Dodger Blue
            "rgba(100, 170, 255, 0.7)",  // Julho - Deep Sky Blue
            "rgba(80, 155, 255, 0.7)",   // Agosto - Cornflower Blue
            "rgba(60, 140, 255, 0.7)",   // Setembro - Medium Slate Blue
            "rgba(40, 125, 255, 0.7)",   // Outubro - Royal Blue
            "rgba(20, 110, 255, 0.7)",   // Novembro - Medium Blue
            "rgba(10, 95, 255, 0.7)"     // Dezembro - Dark Blue
          ],
          borderColor: [
            "rgba(9, 248, 210, 1)",  // Janeiro - Alice Blue
            "rgba(9, 238, 210, 1)",  // Fevereiro - Light Sky Blue
            "rgba(9, 220, 210, 1)",  // Março - Light Steel Blue
            "rgba(9, 215, 210, 1)",  // Abril - Light Blue
            "rgba(9, 200, 210, 1)",  // Maio - Sky Blue
            "rgba(9, 185, 210, 1)",  // Junho - Dodger Blue
            "rgba(9, 170, 210, 1)",  // Julho - Deep Sky Blue
            "rgba(9, 155, 210, 1)",   // Agosto - Cornflower Blue
            "rgba(9, 140, 210, 1)",   // Setembro - Medium Slate Blue
            "rgba(9, 125, 210, 1)",   // Outubro - Royal Blue
            "rgba(9, 110, 210, 1)",   // Novembro - Medium Blue
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
