import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CommentService } from 'src/app/services/comment.service';
import { LikeService } from 'src/app/services/like.service';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-rivista',
  templateUrl: './rivista.component.html',
  styleUrls: ['./rivista.component.scss'],
  encapsulation: ViewEncapsulation.None,
})
export class RivistaComponent implements OnInit {
  rivista: any = null;
  user: any;

  constructor(
    private commentService: CommentService,
    private rivistaService: RivistaService,
    private router: Router,
    private route: ActivatedRoute,
    private auth: AuthService,
    private likeService: LikeService
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.rivistaService.get(slug).subscribe((response: any) => {
        this.rivista = response.data;
        this.user = this.auth.getUser();
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  newComment(comment: any) {
    this.rivista.comments.push(comment);
  }

  deleteRivista() {
    this.rivistaService.delete(this.rivista.id).subscribe(() => {
      this.router.navigateByUrl('/');
    });
  }

  deleteComment(comment_id: number) {
    this.commentService.delete(comment_id).subscribe(() => {
      this.rivista.comments = this.rivista.comments.filter(
        (cmt: any) => cmt.id != comment_id
      );
    });
  }

  like() {
    this.likeService.like({ rivista_id: this.rivista.id }).subscribe(() => {
      this.rivista.likes_count += 1;
      this.rivista.liked = true;
    });
  }

  unlike() {
    this.likeService.unlike({ rivista_id: this.rivista.id }).subscribe(() => {
      this.rivista.likes_count -= 1;
      this.rivista.liked = false;
    });
  }
}
