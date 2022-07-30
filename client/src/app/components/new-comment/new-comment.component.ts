import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { CommentService } from 'src/app/services/comment.service';

@Component({
  selector: 'app-new-comment',
  templateUrl: './new-comment.component.html',
  styleUrls: ['./new-comment.component.scss'],
})
export class NewCommentComponent implements OnInit {
  @Output() commentPosted = new EventEmitter<any>();
  @Input() rivista_id: any;
  comment: any;

  constructor(private commentService: CommentService) {
    this.initComment();
  }

  ngOnInit(): void {
    this.comment.rivista_id = this.rivista_id;
  }

  initComment() {
    this.comment = {
      name: '',
      email: '',
      text: '',
    };
  }

  submit() {
    this.commentService
      .newFromGuest(this.comment)
      .subscribe((response: any) => {
        this.commentPosted.emit(response.data);
        this.initComment();
      });
  }
}
