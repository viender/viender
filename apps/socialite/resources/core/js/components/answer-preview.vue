<template>
    <div class="answer">
        <div class="answer-container">
            <div class="card">
                <div class="card-content">
                    <a :href="getUrl('self_html', answer.question)" v-if="showQuestion"><h2 class="card-title">{{ answer.question.title || 'Deleted question.' }}</h2></a>
                    <ul class="collection">
                        <li class="collection-item avatar">
                            <img :src="getUrl('avatar', answer.owner)" alt="" class="circle">
                            <a :href="getUrl('self_html', answer.owner)" @click="$event.stopPropagation()">
                                <!-- <strong> -->
                                    <span class="answer-content-owner">
                                        {{ `${answer.owner.name}${(answer.credential.id ? ', ' : '')}` }}
                                    </span>
                                <!-- </strong> -->
                            </a>
                            <credential
                                :credential="answer.credential"
                                v-if="answer.credential.id"
                                :with-link="true">
                            </credential>
                        </li>
                    </ul>
                    <div class="answer-content" v-if="!answer.deleted_at" @click="showAnswer()">
                        <div style="display: inline" v-html="answer.preview" v-if="!answer.thumbnail"></div>
                        <div v-if="answer.thumbnail" style="padding-right: 110px; position: relative; min-height: 100px;">
                            <div style="display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; max-height: 102px; overflow: hidden; text-overflow: ellipsis;" v-html="answer.preview"></div>
                            <img style="position: absolute; right: 0; width: 100px !important; top: 0;" :src="answer.thumbnail" alt="answer thumbnail">
                        </div>
                        <a style="cursor: pointer" v-if="answer.preview.length >= 258">(more)</a>
                    </div>
                    <div class="answer-content" style="padding-bottom: 10px;" v-else>
                        <span>Deleted.</span>
                        <a @click="restore()">Restore</a>
                    </div>
                </div>
                <div class="card-action" v-if="!answer.deleted_at">
                    <ul class="card-action-list">
                        <li class="card-action-item">
                            <span style="cursor: pointer;" @click="upvote">
                                <span style="padding-right: 5px;">{{ answer.upvote_count }}</span>
                                <a class="material-icons dp48" :class="answer.upvoted ? 'active' : ''">thumb_up</a>
                            </span>
                        </li>
                        <li class="card-action-item">
                            <a @click="downvote" class="material-icons dp48" :class="answer.downvoted ? 'active' : ''">thumb_down</a>
                        </li>
                        <li class="card-action-item">
                            <a @click="toggleComments()">Comments <span>({{ answer.comment_count }})</span></a>
                        </li>
                        <li class="card-action-item--right">
                            <more-menu ref="moreMenu" :model="answer" v-if="$viender.treasure.client.type === 'desktop'" @click-edit="openEditOverlay">
                            </more-menu>
                            <more-menu-mobile ref="moreMenu" :model="answer" v-else @click-edit="openEditOverlay">
                            </more-menu-mobile>
                        </li>
                        <li class="card-action-item--right">
                            <div class="fb-share-button"
                                :data-href="getUrl('self_html', answer)"
                                data-type="button">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <comment-list :commentable="answer" @comment-posted="incrementCommentCount()" v-if="showComments"></comment-list>
    </div>
</template>

<script>
import answerMixin from '../mixins/answerMixin';
import urlHelper from 'viender_core/js/mixins/urlHelper';
import credential from 'viender_credential/core/js/components/credential';
import moreMenuMobile from './more-menu-mobile';

export default {
    mixins: [answerMixin, urlHelper],

    components: {
        credential,
        moreMenuMobile,
    },
};
</script>
