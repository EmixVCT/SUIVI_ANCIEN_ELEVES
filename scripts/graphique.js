function show_donuts(nbIng,nbMia,nbL3,nbLic,nbBac,nbAut){
		
	var ctxD = document.getElementById("doughnutChart").getContext('2d');
	var myLineChart = new Chart(ctxD, {
			type: 'doughnut',
			data: {
				labels: ["École d'ingenieur", "Miage", "L3", "Licence professionnelle", "Bachelor","Autre"],
				datasets: [{
					data: [nbIng, nbMia, nbL3, nbLic, nbBac,nbAut],
					backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1","#FF5500","#4D5360"],
					hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5","#FF6622", "#616774"]
					}]
				},
			options: {
				responsive: true
			}
		});
}

