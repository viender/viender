import * as types from '../store/mutation-types';
import * as answerEditOverlay from '../components/answer-edit-overlay';
import Answer from '../models/answer';

export default {
    components: {
        'answer-edit-overlay': answerEditOverlay,
    },

    props: {
        answer: {
            type: Object,
            default: null,
        },
        showQuestion: {
            type: Boolean,
            default: true,
        },
    },

    data() {
        return {
            showComments: false,
        };
    },

    computed: {
        answerObj() {
            return new Answer(this.answer);
        },
    },

    methods: {
        showAnswer() {
            if (this.answer.deleted_at) return;
            this.$store.commit('feed/' + types.SET_SHOW_ANSWER_SHOW_MODAL, true);
            this.$store.dispatch('feed/setShowedAnswer', this.answer);

            const url = this.$viender.helpers.getUrl('self_html', this.answer);
            const page = this.answer.title;

            this.$viender.helpers.pushState({page, url});
            this.ga('show', 'Answer Show');
        },

        upvote() {
            const self = this;

            self.answer.upvote()
            .then((response) => {
                self.ga('upvote', 'Answers Upvoted');
            });
        },

        downvote() {
            const self = this;

            self.answer.downvote()
            .then((response) => {
                self.ga('downvote', 'Answers Downvoted');
            });
        },

        toggleComments() {
            this.showComments = !this.showComments;
            this.ga('toggle_comments', 'Answer Toggle Comments');
        },

        incrementCommentCount() {
            this.answer.comment_count += 1;
        },

        restore() {
            const self = this;

            self.answer.delete()
            .then(() => {
                self.answer.deleted_at = null;
            });
        },

        openEditOverlay() {
            const self = this;

            self.$store.commit('questionList/SET_CREATE_MODAL_METHOD', {method: 'PUT'});

            self.$store.commit('moreMenu/SET_ACTIVE_MORE_MENU', {moreMenu: self.$refs.moreMenu});

            axios.get(self.$viender.helpers.getUrl('self', self.answer), {
                params: {
                    only: ['body'],
                },
            })
            .then((response) => {
                self.answer.body = response.data.body;
                self.$store.commit('questionList/' + types.SET_SHOW_ANSWER_CREATE_MODAL, true);
                self.$store.dispatch('editor/setQuestion', {
                    question: self.answer.question,
                    answerText: self.answer,
                });
                self.ga('show_answer_edit_form', 'Question Show Answer Edit Form');
            })
            .catch(function(error) {
                console.log(error);
            });
        },

        handleAtMoreMenuOpen() {
            this.$emit('more-menu-open');
        },

        ga(eventAction, eventLabel = '') {
            if (!window.ga) return;

            ga('send', {
                hitType: 'event',
                eventCategory: 'Answers',
                eventAction: eventAction,
                eventLabel: eventLabel,
            });
        },
    },
};
