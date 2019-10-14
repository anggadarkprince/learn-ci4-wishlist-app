import formatter from "../components/formatter";
import variables from "../components/variables";

export default function () {

    $('.wishlist-card').on('click', '.btn-support-wishlist', function (e) {
        e.preventDefault();
        if (variables.userId) {
            const supportLabel = $(this).find('.label-support-total');
            let totalSupport = formatter.getNumberValue(supportLabel.text().trim());
            let support = 0;
            if ($(this).hasClass('state-supported')) {
                if (totalSupport > 0) {
                    totalSupport -= 1;
                    support = -1;
                    $(this).addClass('text-dark').removeClass('text-success');
                    $(this).find('i').addClass('mdi-thumb-up-outline').removeClass('mdi-thumb-up');
                }
            } else {
                totalSupport += 1;
                support = 1;
                $(this).removeClass('text-dark').addClass('text-success');
                $(this).find('i').removeClass('mdi-thumb-up-outline').addClass('mdi-thumb-up');
            }
            supportLabel.text(formatter.setNumberValue(totalSupport));
            $(this).toggleClass('state-supported');

            let formData = new FormData();
            formData.append('support', support);
            formData.append('csrf_token', variables.csrfToken);
            const option = {
                method: "POST",
                body: formData
            };
            fetch($(this).prop('href'), option)
                .then(result => result.json())
                .then(data => {
                    console.log(data);
                })
                .catch(console.log);

        } else {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/login?redirect=' + window.location.href);
        }
    });

};